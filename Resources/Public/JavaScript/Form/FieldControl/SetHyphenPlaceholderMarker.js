/**
 * Module TYPO3/CMS/HyphenDictionary/Form/FieldControl/SetHyphenPlaceholderMarker
 *
 * JavaScript to add a placeholder to a word that indicates an optional word break
 * @exports TYPO3/CMS/HyphenDictionary/Form/FieldControl/SetHyphenPlaceholderMarker
 */
define(function() {
  'use strict';

  /**
   * @exports TYPO3/CMS/HyphenDictionary/Form/FieldControl/SetHyphenPlaceholderMarker
   */
  var SetHyphenPlaceholderMarker = {};

  /**
   * @param {object} element
   * @param {string} value
   */
  SetHyphenPlaceholderMarker.setElementValue = function(element, value) {
    element.value = value;
    var event;
    if (typeof(Event) === 'function') {
      event = new Event("change");
    }
    else {
      event = document.createEvent('Event');
      event.initEvent('change', true, true);
    }
    element.dispatchEvent(event);
  }

  /**
   * @param {object} element
   * @param {string} placeholder
   */
  SetHyphenPlaceholderMarker.insertPlaceholder = function(element, placeholder) {
    var newValue;
    if (element.selectionStart || element.selectionStart === '0') {
      var startPos = element.selectionStart;
      var endPos = element.selectionEnd;
      newValue = element.value.substring(0, startPos)
        + placeholder
        + element.value.substring(endPos, element.value.length);
    } else
      newValue = placeholder;
    SetHyphenPlaceholderMarker.setElementValue(element, newValue);
  };

  SetHyphenPlaceholderMarker.initializeEvents = function() {
    var buttons = document.getElementsByClassName('hyphen-placeholder-marker');
    if (buttons.length)
      buttons.item(0).addEventListener('click', function(e) {
        e.preventDefault();
        var elementName = 'data'+this.dataset.inputName,
            element = document.querySelector('input[data-formengine-input-name="'+elementName+'"]');
        SetHyphenPlaceholderMarker.insertPlaceholder(element, this.dataset.placeholder);
      });
  };

  SetHyphenPlaceholderMarker.initializeEvents();

  return SetHyphenPlaceholderMarker;
});
