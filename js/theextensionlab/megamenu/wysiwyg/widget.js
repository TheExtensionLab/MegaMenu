/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

WysiwygWidget.chooser.prototype.chooseNew = function(newUrl) {
    // Show or hide chooser content if it was already loaded
    var responseContainerId = this.getResponseContainerId();

    // Otherwise load content from server
    new Ajax.Request(newUrl,
        {
            parameters: {element_value: this.getElementValue(), element_label: this.getElementLabelText()},
            onSuccess: function(transport) {
                try {
                    widgetTools.onAjaxSuccess(transport);
                    this.dialogContent = widgetTools.getDivHtml(responseContainerId, transport.responseText);
                    this.openDialogWindow(this.dialogContent);
                } catch(e) {
                    alert(e.message);
                }
            }.bind(this)
        }
    );
};

//This override replaces the regex because the default version doesn't allow escaped quotes in the
//widget option value (Such as what we have with escaped category JSON)
WysiwygWidget.Widget.prototype.initOptionValues = function() {

    if (!this.wysiwygExists()) {
        return false;
    }

    var e = this.getWysiwygNode();
    if (e != undefined && e.id) {
        var widgetCode = Base64.idDecode(e.id);
        if (widgetCode.indexOf('{{widget') != -1) {
            this.optionValues = new Hash({});
            widgetCode.gsub(/([a-z0-9\_]+)\s*\=\s*\"(.+?)\"(?=\}\}| )/i, function(match){
                if (match[1] == 'type') {
                    this.widgetEl.value = match[2];
                } else {
                    this.optionValues.set(match[1], match[2]);
                }
            }.bind(this));

            this.loadOptions();
        }
    }
};

function getNodeData(node, fields) {
    var data = {};

    var nodeId = node.id;
    // loop through desired fields

    if(nodeId != 2) {
        data['id'] = nodeId;
    }

    if (node.hasChildNodes()) {
        if(nodeId == 2) {
            var categories = data.categories = [];
            node.eachChild(function (child) {
                categories.push(getNodeData(child, fields));
            });
        } else{
            var children = data.children = [];
            node.eachChild(function (child) {
                children.push(getNodeData(child, fields));
            });
        }
    }
    return data;
}