<template>
    <div>
        <button class="btn btn-primary" @click="setOfficeRed">
            Cuddles
        </button>
        <div class="flex flex-wrap my-6 -mx-3">
            <div class="sm:w-1/2 md:w-1/3 px-3" v-for="(room) in rooms" :key="room.name">
                <div class="card shadow-md p-3">
                    <h2 class="text-xl">{{ room.name }}</h2>
                    <div class="my-4" v-for="(lightNumber, index) in room.lights" :key="index">
                        <div v-if="!! lights[lightNumber]">
                            {{ lights[lightNumber].name }}
                            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input @change="setLight($event, lightNumber)" type="checkbox" :id="lights[lightNumber].uniqueid" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" :checked="lights[lightNumber].state.on" />
                                <label :for="lights[lightNumber].uniqueid" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>
                            <input v-if="!! lights[lightNumber].state.xy" type="color" @change="setColorLight($event, lightNumber)" :value="cie_to_rgb(lights[lightNumber].state.xy[0], lights[lightNumber].state.xy[1], lights[lightNumber].state.bri)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import converter from '@q42philips/hue-color-converter'
    export default {
        data() {
            return {
                baseUrl: `https://${process.env.MIX_HUE_BRIDGE_IP}/api/${process.env.MIX_HUE_USER}`,
                lights: {},
                rooms: {}
            }
        },
        created() {
            this.getRooms();
            this.getLights()
        },
        methods: {
            setOfficeRed() {
                let lightOn = {
                    "on": true,
                    "xy": [0.675, 0.322],
                    "bri": 254
                };
                let lightOff = {
                    "on": false
                };
                let times = 0;
                let ref = this;
                let cuddle = setInterval(function () {
                    times++;
                    if (times % 2 === 0) {
                        ref.setOfficeLamp(lightOn);
                    } else {
                        ref.setOfficeLamp(lightOff);
                    }

                    if (times === 10 * 2) {
                        clearInterval(cuddle);
                    }
                }, 1000);
            },
            setOfficeLamp(data) {
                let url = this.baseUrl + `/lights/7/state`;

                axios.put(url, data).then(() => {
                }).catch(error => {
                    console.log(error);
                });
            },
            getRooms() {
                axios.get(this.baseUrl + "/groups").then(response => {
                    let arr = [],
                        keys = Object.keys(response.data);

                    for (var i = 0, n = keys.length; i < n; i++) {
                        var key = keys[i];
                        arr[key] = response.data[key];
                    }

                    this.rooms = arr.filter(function (item) {
                        return item != null && item.type === "Room"
                    });
                });
            },
            getLights() {
                axios.get(this.baseUrl + "/lights").then(response => {
                    this.lights = response.data
                });
            },
            setLight(event, lightNumber) {
                let url = this.baseUrl + `/lights/${lightNumber}/state`;
                let data = {
                    "on": event.currentTarget.checked,
                    "bri": 254
                };

                axios.put(url, data)
                    .catch(error => {
                        console.log(error);
                    })
            },
            setColorLight(event, lightNumber) {
                const rgb = this.hexToRgbA(event.currentTarget.value);
                const xy = converter.calculateXY(rgb.r, rgb.g, rgb.b);

                let url = this.baseUrl + `/lights/${lightNumber}/state`;
                let data = {
                    "on": true,
                    "xy": xy,
                    "bri": 254
                };

                axios.put(url, data)
                    .catch(error => {
                        console.log(error);
                    })
            },
            hexToRgbA(hex) {
                let c;
                if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
                    c = hex.substring(1).split('');
                    if (c.length === 3) {
                        c = [c[0], c[0], c[1], c[1], c[2], c[2]];
                    }
                    c = '0x' + c.join('');
                    return {
                        r: (c >> 16) & 255,
                        g: (c >> 8) & 255,
                        b: c & 255,
                    }
                }
            },
            cie_to_rgb(x, y, brightness)
            {
                //Set to maximum brightness if no custom value was given (Not the slick ECMAScript 6 way for compatibility reasons)
                if (brightness === undefined) {
                    brightness = 254;
                }

                const z = 1.0 - x - y;
                const Y = (brightness / 254).toFixed(2);
                const X = (Y / y) * x;
                const Z = (Y / y) * z;

                //Convert to RGB using Wide RGB D65 conversion
                let red 	=  X * 1.656492 - Y * 0.354851 - Z * 0.255038;
                let green 	= -X * 0.707196 + Y * 1.655397 + Z * 0.036152;
                let blue 	=  X * 0.051713 - Y * 0.121364 + Z * 1.011530;

                //If red, green or blue is larger than 1.0 set it back to the maximum of 1.0
                if (red > blue && red > green && red > 1.0) {

                    green = green / red;
                    blue = blue / red;
                    red = 1.0;
                }
                else if (green > blue && green > red && green > 1.0) {

                    red = red / green;
                    blue = blue / green;
                    green = 1.0;
                }
                else if (blue > red && blue > green && blue > 1.0) {

                    red = red / blue;
                    green = green / blue;
                    blue = 1.0;
                }

                //Reverse gamma correction
                red 	= red <= 0.0031308 ? 12.92 * red : (1.0 + 0.055) * Math.pow(red, (1.0 / 2.4)) - 0.055;
                green 	= green <= 0.0031308 ? 12.92 * green : (1.0 + 0.055) * Math.pow(green, (1.0 / 2.4)) - 0.055;
                blue 	= blue <= 0.0031308 ? 12.92 * blue : (1.0 + 0.055) * Math.pow(blue, (1.0 / 2.4)) - 0.055;


                //Convert normalized decimal to decimal
                red 	= Math.round(red * 255);
                green 	= Math.round(green * 255);
                blue 	= Math.round(blue * 255);

                if (isNaN(red))
                    red = 0;

                if (isNaN(green))
                    green = 0;

                if (isNaN(blue))
                    blue = 0;

                return this.rgbToHex(red, green, blue);
            },
            rgbToHex(r,g,b) {
                return "#" + this.componentTohex(r) + this.componentTohex(g) + this.componentTohex(b);
            },
            componentTohex(c) {
                let hex = c.toString(16);
                return hex.length === 1 ? "0" + hex : hex;
            }
        }
    }
</script>
