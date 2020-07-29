<?php


    namespace App\Http\Controllers;


    use App\Models\Board;
    use Illuminate\Http\Request;

    class BoardsInvitationsController extends Controller
    {
        public function store(Request $request, $id)
        {
            $board = Board::find($id);
            if($board->members()->contains($request->get('user_id'))) {
                return response('User is already invited', 403);
            }
            $board->invite($request->get('user_id'));

            return response('User have been invited', 200);
        }

        public function destroy(Request $request, $id)
        {
            $board = Board::find($id);

            $board->deleteMember($request->get('user_id'));

            return response('User have been invited', 200);
        }
    }
