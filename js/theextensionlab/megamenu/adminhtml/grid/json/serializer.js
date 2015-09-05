/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.lab/license/license.txt - Commercial License
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

String.prototype.addSlashes = function()
{
    return this.replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
};

var jsonSerializerController = Class.create();
jsonSerializerController.prototype = Object.extend(Object.clone(serializerController.prototype), {
    serializeObject: function(){
        if(this.multidimensionalMode){
            var clone = this.gridData.clone();
            clone.each(function(pair) {
                //Put the data in array to avoid "}}" which will conflict with the widget directive we now get ]}] which wont match.
                //Not perfect but better than an unreadable base_64 string which is the default for serializer.
                if(JSON.stringify(pair.value).charAt(0) != "[") {
                    var data = [];
                    data.push(pair.value);
                    clone.set(pair.key, data);
                }
            });

            return JSON.stringify(clone.toJSON()).addSlashes();
        }
        else{
            return this.gridData.values().join('&');
        }
    }
});