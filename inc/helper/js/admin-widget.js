/**
 * Script Js for Widget Slider image
 */
function addInputWidgetHomeSliderImage(event, innerField) {
  event.preventDefault();

  var btnClick = event.target;
  var inputWrap = btnClick.closest(".input__wrap");
  var inputBox = inputWrap.querySelector(".input__box");

  var inputField = document.createElement("div");
  inputField.classList.add("input__content");
  inputField.innerHTML = innerField;

  if (inputBox) {
    inputBox.appendChild(inputField);
  }
}

// Input hidden change save Widget
function saveWidgetInputChange(event) {
  event.preventDefault();

  const regex = /^widget-\d*_/g;
  var buttonClick = event.target;
  var widgetParrent = buttonClick.closest(".widget");

  if (widgetParrent) {
    var stringId = widgetParrent.id;
    var trimID = stringId.replace(regex, "");
    var idButtonSave = "widget-" + trimID + "-savewidget";

    if (document.getElementById(idButtonSave)) {
      // Old version Widget
      document.getElementById(idButtonSave).disabled = false;
    }
  }
}

/**
 * Widget Page - Delete btn to save
 */
function deleteInputFieldWidget(event) {
  event.preventDefault();

  var btnClick = event.target;
  var widgetParrent = btnClick.closest(".widget");
  var inputContent = btnClick.closest(".input__content");

  var stringId = widgetParrent.id;

  const regex = /^widget-\d*_/g;

  var trimID = stringId.replace(regex, "");
  var idButtonSave = "widget-" + trimID + "-savewidget";

  inputContent.remove();
  if (document.getElementById(idButtonSave)) {
    document.getElementById(idButtonSave).disabled = false;
  }
}
