/*jshint esversion: 6 */
"use strict";

import "jquery";
import "popper.js";
import "bootstrap";

$("[data-toggle='sidebar']").click((e) => {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});

// add all h2"s with an id as a subitem in the navigation
$("h2[id]").each((index, element) => {
  const $element = $(element);

  // create wrapper ul if needed
  const $parent = $("#menu__" + $element.attr("id").split("__")[0]);

  if ($parent.find("ul").length === 0) {
    $parent.append("<ul></ul>");
  }
  const $ul = $parent.find("ul");

  // cleanup label
  let label = $element.clone();
  label.find("small").remove();
  label = $.trim(label.html());

  $ul.append(
      "<li class=\"nav-item\">" +
      "  <a class=\"nav-link\" href=\"#" + $element.attr("id") + "\">" + label + "</a>" +
      "</li>"
  );
});


