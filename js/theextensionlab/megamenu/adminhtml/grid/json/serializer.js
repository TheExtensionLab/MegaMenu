String.prototype.addSlashes = function()
{
    return this.replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
};

var jsonSerializerController = Class.create();
var clonedSerializer = Object.clone(serializerController.prototype);
jsonSerializerController.prototype = Object.extend(clonedSerializer, {
    serializeObject: function(){
        if(this.multidimensionalMode){
            var clone = this.gridData.clone();
            clone.each(function(pair) {
                //Put the data in array to avoid "}}" which will conflict with the widget directive we now get ]}] which wont match.
                //Not perfect but better than an unreadable base_64 string which is the default for serializer.
                var data = [];
                data.push(pair.value);
                clone.set(pair.key, data);
            });

            var jsonString = JSON.stringify(clone.toJSON()).addSlashes();

            return jsonString;
        }
        else{
            return this.gridData.values().join('&');
        }
    }
});