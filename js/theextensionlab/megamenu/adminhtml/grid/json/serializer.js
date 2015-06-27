String.prototype.addSlashes = function()
{
    return this.replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
};

var jsonSerializerController = Class.create();
jsonSerializerController.prototype = Object.extend(serializerController.prototype, {
    serializeObject: function(){
        if(this.multidimensionalMode){
            var clone = this.gridData.clone();
            clone.each(function(pair) {
                clone.set(pair.key, pair.value);
            });

            var jsonString = JSON.stringify(clone.toJSON()).addSlashes();

            return jsonString;
        }
        else{
            return this.gridData.values().join('&');
        }
    }
});