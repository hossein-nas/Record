window.$ = window.jQuery = require('jquery');
// alert("Hi there :)");
import notify from "./components/getInfo.js";
import sendcommand from "./components/sendcommand.js";
import getCabintInfo from "./components/getCabinetInfo.js";
import registerNew from "./components/registerNew.js";
import rechargeCard from "./components/rechargeCard.js";
import manageUsers from "./components/manage_users.js";

notify();
sendcommand();
getCabintInfo();
registerNew();
rechargeCard();
manageUsers();