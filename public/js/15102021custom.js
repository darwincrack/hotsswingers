var padding;
var data;
var svg;
var container;
var vis;
var pie;
var arc;
var arcs;
var oldrotation;
var rotation;


$(document).ready(function(){$("body img").on("contextmenu",function(a){return!1});
$("body img").mousedown(function(e){
    e.preventDefault()
});
});


window.mobileCheck = function() {
  let check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
};


const Website = {
  drawRuleta (data,nivel) {

$('#chart').find('svg').first().remove();
if(nivel == 1){
data = data.datos.datosniveluno;

}else if(nivel == 2){
data = data.datos.datosniveldos;
    
}else if(nivel == 3){
data = data.datos.datosniveltres;
    
}else{
data = data.datos.datosniveluno;

}


   padding = {top:20, right:40, bottom:0, left:0},
            w = 260 - padding.left - padding.right,
            h = 200 - padding.top  - padding.bottom,
            r = Math.min(w, h)/2,
            rotation = 1000,
            oldrotation = 0,
            picked = 100000,
            oldpick = [],
            color = d3.scale.category20();//category20c()

         svg = d3.select('#chart')
            .append("svg")
            .data([data])
            .attr("width",  w + padding.left + padding.right)
            .attr("height", h + padding.top + padding.bottom);
        container = svg.append("g")
            .attr("class", "chartholder")
            .attr("transform", "translate(" + (w/2 + padding.left + 30) + "," + (h/2 + padding.top) + ")");
        vis = container
            .append("g");
            
        pie = d3.layout.pie().sort(null).value(function(d){return 1;});
        // declare an arc generator function
        arc = d3.svg.arc().outerRadius(r);
        // select paths, use arc generator to draw
        arcs = vis.selectAll("g.slice")
            .data(pie)
            .enter()
            .append("g")
            .attr("class", "slice");
            


        arcs.append("path")
            .attr("fill", function(d, i){ 

              return randColor();

               })
            .attr("d", function (d) { return arc(d); })
            .attr("stroke", "black")
            .attr("stroke-width", "4");
        // add the text
        arcs.append("text").attr("transform", function(d){
                d.innerRadius = 0;
                d.outerRadius = r;
                d.angle = (d.startAngle + d.endAngle)/2;
                return "rotate(" + ((d.angle * 180 / Math.PI - 90) -179) + ")translate(" + ((d.outerRadius -40)-79) +")";
            })
            .attr("text-anchor", "end")
            .text( function(d, i) {
                return data[i].task;
            });



         var x = 35;
  
        svg.append("g")
            .attr("transform", "translate(" + (x) + "," + ((h/2)+padding.top) + ")")
            .append("path")
            .attr("d", "M" + (r*.15) + ",0L0," + (r*.05) + "L0,-" + (r*.05) + "Z")
            .style({"fill":"black"}); 

container.append("circle")
            .attr("cx", 0)
            .attr("cy", 0)
            .attr("r", 5)
            .style({"fill":"red","cursor":"pointer"});




function randColor(){
    return `hsla(${~~(360 * Math.random())},70%,70%,0.8)`
  }

/*function randColor() {
    var color = (function lol(m, s, c) {
                    return s[m.floor(m.random() * s.length)] +
                        (c && lol(m, s, c - 1));
                })(Math, '3456789ABCDEF', 4);
    return '#'+color;
}*/


        function rotTween(to) {
          var i = d3.interpolate(oldrotation % 360, rotation);
          return function(t) {
            return "rotate(" + i(t) + ")";
          };
        }
        
        
        function getRandomNumbers(){
            var array = new Uint16Array(1000);
            var scale = d3.scale.linear().range([360, 1440]).domain([0, 100000]);
            if(window.hasOwnProperty("crypto") && typeof window.crypto.getRandomValues === "function"){
                window.crypto.getRandomValues(array);
                
            } else {
                //no support for crypto, get crappy random numbers
                for(var i=0; i < 1000; i++){
                    array[i] = Math.floor(Math.random() * 100000) + 1;
                }
            }
            return array;
        }










function gira(){
  vis.transition(1000).duration(30000).attrTween("transform", rotTween) .each("end", function(){
    oldrotation = rotation;
    gira();
              
  });



}

  },
  
  girarIndefinido () {

        function rotTween(to) {
          var i = d3.interpolate(oldrotation % 360, rotation);
          return function(t) {
            return "rotate(" + i(t) + ")";
          };
        }
        



      vis.transition(1000).duration(30000).attrTween("transform", rotTween) .each("end", function(){
    oldrotation = rotation;
    Website.girarIndefinido()
              
  });
 
  },

  spin(data,nivel){




if(nivel == 1){
data = data.datos.datosniveluno;

}else if(nivel == 2){
data = data.datos.datosniveldos;
    
}else if(nivel == 3){
data = data.datos.datosniveltres;
    
}else{
data = data.datos.datosniveluno;

}
   
           function rotTween(to) {
          var i = d3.interpolate(oldrotation % 360, rotation);
          return function(t) {
            return "rotate(" + i(t) + ")";
          };
        }
        
            
            container.on("click", null);
    
            if(oldpick.length == data.length){

               oldpick =[];

            }
            var  ps       = 360/data.length,
                 pieslice = Math.round(1440/data.length),
                 rng      = Math.floor((Math.random() * 1440) + 360);
                
            rotation = (Math.round(rng / ps) * ps);
            
            picked = Math.round(data.length - (rotation % 360)/ps);
            picked = picked >= data.length ? (picked % data.length) : picked;
            if(oldpick.indexOf(picked) !== -1){
                d3.select(this).call(Website.spin(data,nivel));
                return;
            } else {
                oldpick.push(picked);
            }
            rotation += 270 - Math.round(ps/2);
            vis.transition()
                .duration(3000)
                .attrTween("transform", rotTween)
                .each("end", function(){
                    //mark question as seen
                  /*  d3.select(".slice:nth-child(" + (picked + 1) + ") path")
                        .attr("fill", "#111");*/
                    //populate question
                    d3.select("#question_"+nivel+" h1")
                        .text(data[picked].task);
                    oldrotation = rotation;
              
                   

                    setTimeout(Website.girarIndefinido(), 5000);
              
                    /* Comment the below line for restrict spin to sngle time */
                   // container.on("click", spin);
                });
       
return data[picked].task;
  }

}

