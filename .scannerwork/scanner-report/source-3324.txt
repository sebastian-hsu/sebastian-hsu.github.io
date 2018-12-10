String.prototype.dbc2sbc = function ()
{
return this.replace(/[\uff01-\uff5e]/g,function(a){return String.fromCharCode(a.charCodeAt(0)-65248);}).replace(/\u3000/g," ");
}