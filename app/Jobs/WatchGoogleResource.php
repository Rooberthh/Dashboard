<?php


    namespace App\Jobs;


    abstract class WatchGoogleResource
    {
        protected $synchronizable;

        public function __construct($synchronizable)
        {
            $this->synchronizable = $synchronizable;
        }

        public function handle()
        {
            try {

            $synchronization = $this->synchronizable->synchronization;

            $response = $this->getGoogleRequest(

            // Thanks to our previous refactoring we can now grab the
            // Google Calendar service directly from the synchronizable.
                $this->synchronizable->getGoogleService('Calendar'),

                // We will implement this in the next section.
                // It uses the synchronization's data to create
                // a new \Google_Service_Calendar_Channel object.
                $synchronization->asGoogleChannel()
            );

            // We can now update our synchronization model
            // with the provided resource_id and expired_at.
            $synchronization->update([
                'resource_id' => $response->getResourceId(),
                'expired_at' => Carbon::createFromTimestampMs($response->getExpiration())
            ]);

            } catch(\Google_Service_Exception $e) {

            }
        }

        abstract public function getGoogleRequest($service, $channel);
    }
