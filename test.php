<html><head><script async="" src="https://api.twitter.com/1/geo/search.json?callback=jQuery17105994699615985155_1389370875259&amp;query=Berlin&amp;_=1389370928175"></script><script async="" src="https://api.twitter.com/1/geo/search.json?callback=jQuery17105994699615985155_1389370875258&amp;query=Berlin&amp;_=1389370908533"></script><style type="text/css">.gm-style .gm-style-mtc label,.gm-style .gm-style-mtc div{font-weight:400}</style><style type="text/css">.gm-style .gm-style-cc span,.gm-style .gm-style-cc a,.gm-style .gm-style-mtc div{font-size:10px}</style><link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700"><style type="text/css">@media print {  .gm-style .gmnoprint, .gmnoprint {    display:none  }}@media screen {  .gm-style .gmnoscreen, .gmnoscreen {    display:none  }}</style><style type="text/css">.gm-style div,.gm-style span,.gm-style label,.gm-style a{font-family:Roboto,Arial,sans-serif;font-size:11px;font-weight:400}.gm-style div,.gm-style span,.gm-style label{text-decoration:none}.gm-style img{border:0;padding:0;margin:0}</style>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>using twitter-geo-api with google-maps - jsFiddle demo by doktormolle</title>
  
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.js" style=""></script>
  <link rel="stylesheet" type="text/css" href="/css/normalize.css">
  
  
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  
  <style type="text/css">
    

  </style>
  
<script type="text/javascript" charset="UTF-8" src="http://maps.gstatic.com/cat_js/intl/de_de/mapfiles/api-3/15/6/%7Bcommon,map%7D.js"></script><script type="text/javascript" charset="UTF-8" src="http://maps.gstatic.com/cat_js/intl/de_de/mapfiles/api-3/15/6/%7Butil,onion%7D.js"></script><script type="text/javascript" charset="UTF-8" src="http://maps.gstatic.com/cat_js/intl/de_de/mapfiles/api-3/15/6/%7Bcontrols,stats%7D.js"></script><script type="text/javascript" charset="UTF-8" src="http://maps.gstatic.com/cat_js/intl/de_de/mapfiles/api-3/15/6/%7Bmarker%7D.js"></script></head>
<body>
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script><script src="http://maps.gstatic.com/intl/de_de/mapfiles/api-3/15/6/main.js" type="text/javascript"></script>



  


<script type="text/javascript">//<![CDATA[ 

  var poly=null;

    
  function initialize() {
    var myLatLng = new google.maps.LatLng(24.886436490787712, -70.2685546875);
    var myOptions = {
      zoom: 5,
      center: myLatLng,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    };

    

    map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);

$('input:button')
  .click(function()
    {
      var _this   = $(this),
          _prev   =_this.prev(),
          _val    = _prev.val();

      _this.prev('select').remove();
      _this.prev('input:text').show();      
      if(_prev[0].tagName=='SELECT')
      {
        placeRequest(_val);
        return;
      }
      if(!_val.match(/[a-z]{3,}/i))
      {
        alert('enter a value')
      }
      else
      {
        //request the place-id
        $.getJSON('https://api.twitter.com/1/geo/search.json?callback=?',
                  {query:_val},
                  function(r)
                  {
                    if(!r.result.places.length)
                    {
                      alert('no place found');
                    }
                    else
                    {
                      if(r.result.places.length>1)
                      {
                        var list=$('<select><optgroup label="choose a location"></optgroup></select>');
                        for(var i=0;i<r.result.places.length;++i)
                        {
                          $('<option/>')
                            .text(r.result.places[i].full_name)
                             .val(r.result.places[i].url)
                              .appendTo($('optgroup',list));
                          _this.prev('input:text').hide();
                          
                        }
                        _this.before(list);
                      }
                      else
                      {
                        placeRequest(r.result.places[0].url);
                      }
                      
                    }
                  }
                 )
      }
    }
  );
  
}
function placeRequest(url)
{
  $.getJSON(url+'?callback=?',
                                function(rr)
                                {console.log('rr',rr)
                                  if(rr.geometry.type=='Polygon')
                                  {
                                    drawPolygon(rr.geometry.coordinates[0])
                                  }
                                  else
                                  {
                                    alert('no polygon found')
                                  }
                                }
                               );
}
function drawPolygon(p)
{
  if(window.poly)window.poly.setMap(null);
  var pp=[],bounds=new google.maps.LatLngBounds();
  for(var i=0;i<p.length;++i)
  {
    pp.push(new google.maps.LatLng(p[i][1],p[i][0]));
    bounds.extend(pp[pp.length-1]);
  }
    window.poly=new google.maps.Polygon({
      paths: pp,
      strokeColor: "#FF0000",
      strokeOpacity: 0.8,
      strokeWeight: 3,
      fillColor: "#FF0000",
      fillOpacity: 0.35
    });
    
    window.poly.setMap(map);
    map.fitBounds(bounds);

  }

$(initialize);
//]]>  

</script>







</body></html>