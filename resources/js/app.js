window.$ = window.jQuery = require('jquery');
// alert("Hi there :)");
import notify from "./components/getInfo.js";
import sendcommand from "./components/sendcommand.js";
import getCabintInfo from "./components/getCabinetInfo.js";
notify();
sendcommand();
getCabintInfo();