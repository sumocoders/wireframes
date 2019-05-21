/*jshint esversion: 6 */
"use strict";

import $ from "jquery";
import "popper.js";
import "bootstrap";
import "frameworkstylepackage/src/js/SumoPlugins";
import "select2";

$(document).ready(function () {
    $("select.select2").select2({
        dropdownAutoWidth: true,
        width: "auto"
    });
});
