/*
 * This is the codebase to construct a visual tree for CoC
 *
 * Requires:  jQuery, jQuery-UI
 *
 * Users: u_id, f_name, l_name, email
 * CoC:   [unk]
 *		CoC Node:   {u_id, positioni (pk), children(list of positions)}
 *
 * */
 
 /*
var node = {
	position: "",
    children:["","",""],
    u_id: 1,
    parent: ""
}; 
*/

function createNode(obj){
	this.node = {
		position: "",
    	children:[],
    	u_id: -1,
    	parent: null,
        html: $("<div class='slot' />")
		};
    if (obj){
        this.node.position = obj.position || "";
        this.node.children = obj.children || [];
        this.node.u_id =     obj.u_id || -1;
        this.node.parent =   obj.parent || null;
        this.node.html=      obj.html || $("<div class='slot' />");
    	}
    
    this.node.html.on("click", function(event){
    	event.stopPropagation();
        alert("[Insert Bio]");
        
    });
    this.GetChildren = function(){ return this["node"]["children"]; }
    this.AddChild = function(child){ this.node.children.push(child); }
    this.RemoveChild = function(position){ 
        var index = -1;
        for (var i = 0; i< this.node.children.length;i++){
         	var row = this.node.children[i];
            if (row["position"] === position){
                index = i;
                break;
                }
        	}
        if (index == -1) return;
        
        this.node.children.slice(index, 1);
    	}
    
    this.SetParent = function(position){ this.node.parent = position;};
    this.GetParent = function(){return this.node.parent;};
    
    this.SetPosition = function(position){ this.node.position = position;};
    this.GetPosition = function(){ return this.node.position; };
    
    this.SetUserId = function(u_id){ this.node.u_id = u_id; };
    this.GetUserId = function(){ return this.node.u_id;};
    
    this.SetHtml = function($html){ this.node.html = $html;};
    this.GetHtml = function(){ return this.node.html; };
    return this;
	}

var coc = {
	"pl":  new createNode(),
	"psg": new createNode()
 	}
coc["pl"].AddChild("psg");
coc["pl"].SetPosition("pl");
//coc["pl"].SetHtml($("<div />"));
coc["psg"].SetParent("pl");
coc["psg"].SetPosition("psg");
//coc["psg"].SetHtml($("<div />"));

 for (var i = 0; i< 4; i++){
	coc[""+i+"sl"]=new createNode();
    //coc[""+i+"sl"].SetPosition("psg");
    coc[""+i+"sl"].SetPosition(""+i+"sl");
    //coc[""+i+"sl"].SetHtml($("<div />"));
    coc[""+i+"sl"].SetParent("psg");
     
    coc["psg"].AddChild(""+i+"sl");
	for (var j = 0; j< 2; j++){
		var num = i*2+j;
		coc[""+num+"tl"] = new createNode();
        coc[""+num+"tl"].SetParent(""+i+"sl");
        coc[""+num+"tl"].SetPosition(""+num+"tl");
        //coc[""+num+"tl"].SetHtml($("<div />"));
        coc[""+i+"sl"].AddChild(""+num+"tl");
		for (var k = 0; k< 3; k++){
			coc[""+Number(num*3+k)+"tm"] = new createNode();
            coc[""+Number(num*3+k)+"tm"].SetParent(""+num+"tl");
            //coc[""+Number(num*3+k)+"tm"].SetHtml($("<div />"));
            coc[""+Number(num*3+k)+"tm"].SetPosition(""+Number(num*3+k)+"tm");
            coc[""+num+"tl"].AddChild( ""+Number(num*3+k)+"tm" );
		 	}
	 	}
 	}

//console.log(coc);

//create structure:

$(function(){
	for( var prop in coc ){
     	var row = coc[prop];
        //console.log("Row: ", row);
        
        row.GetHtml().append(row.GetPosition() + "<br />");
        /*
        if (prop.indexOf("sl") != -1){
            row.GetHtml().addClass("sl");
        }
        */
        
        if (row.GetParent() == null){
            $("body").append($("<center />").append(row.GetHtml()));
        }else{
            //console.log("Parent: "+ row.GetParent());
            coc[row.GetParent()].GetHtml().append(row.GetHtml());
        }
    }
    
    //builds a graphical representation.
    $("div.slot").each(function(){
    	var $siblings = $(this).siblings(".slot").andSelf();
        if ($siblings.length > 1){
            //$siblings.css("display", "inline");
            
            //exact. not dynamic
            var p_width = $siblings.parent().width()
            var w = p_width ;
            w /=  $siblings.length;
            w -= 3;
            w = (w/p_width)*100;
            //w /= $siblings.parent().width() * 100;
            $siblings.css({float:"left","width":w +"%"});
        }
        //console.log($siblings);
    });
});
 //console.log(Object.keys(coc).length);


$(function(){
	/*
	var tree = function(users, CoCMap)
		{
			var result = $("<div />");

			var buildTree = function(coc){
				var $div = $("<div /");
				var $retVal = $div.clone();
				
				var walkChild = function(child, placement){
					for (var i = 0; i < current.children.length; i++){
						var child = coc[current.children[i].position];
					
						placement.append($div.clone().append(child["l_name"]]))
						var $child = $div.clone();
						placement.append($child)
						walkChild(child, $child);
					
					
						}
					
					}
				
				var current = coc["pl"];
				//$retVal.append($div.clone().append(current);
				var place = $("<div />");
				$retVal.append(place);
				walkChild(current, place);


				}(CoCMap);

		}
		*/
	});
