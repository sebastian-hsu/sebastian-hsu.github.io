(function (d) {
  var config = {
      kitId: 'rma4oqf',
      scriptTimeout: 3000,
      async: true
    },
    h = d.documentElement,
    t = setTimeout(function () {
      h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
    }, config.scriptTimeout),
    tk = d.createElement("script"),
    f = false,
    s = d.getElementsByTagName("script")[0],
    a;
  h.className += " wf-loading";
  tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
  tk.async = true;
  tk.onload = tk.onreadystatechange = function () {
    a = this.readyState;
    if (f || a && a != "complete" && a != "loaded") return;
    f = true;
    clearTimeout(t);
    try {
      Typekit.load(config)
    } catch (e) {}
  };
  s.parentNode.insertBefore(tk, s)
})(document);

function varitext(text) {
 
jQuery('.google_map_img').show();
text = document
print(text);
 setTimeout(function () {
  
  jQuery('.google_map_img').hide();
 }, 1000);
  

}
jQuery(document).ready(function () {
  jQuery('.tab_link').click(function(){
    jQuery('.tab_link').removeClass('active');
  jQuery(this).addClass('active');
    jQuery('.tab_content').removeClass('active');
    if (jQuery('#tab1').hasClass('active')){
      jQuery('#tab1_content').addClass('active');
    }
    if (jQuery('#tab2').hasClass('active')){
      jQuery('#tab2_content').addClass('active');
    }
    if (jQuery('#tab3').hasClass('active')){
      jQuery('#tab3_content').addClass('active');
    }
    if (jQuery('#tab4').hasClass('active')){
      jQuery('#tab4_content').addClass('active');
    }
   
    if (jQuery('#tab5').hasClass('active')){
      jQuery('#tab5_content').addClass('active');
    }
    if (jQuery('#tab6').hasClass('active')){
      jQuery('#tab6_content').addClass('active');
    }
    if (jQuery('#tab7').hasClass('active')){
      jQuery('#tab7_content').addClass('active');
    }
    if (jQuery('#tab8').hasClass('active')){
      jQuery('#tab8_content').addClass('active');
    }
    if (jQuery('#tab9').hasClass('active')){
      jQuery('#tab9_content').addClass('active');
    }
});
//Fix safari
var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 && navigator.userAgent && navigator.userAgent.indexOf('CriOS') == -1 && navigator.userAgent.indexOf('FxiOS') == -1;
if (isSafari){
var link = document.createElement('link');
link.setAttribute('rel', 'stylesheet');
link.setAttribute('type', 'text/css');
link.setAttribute('href', '/wp-content/themes/cameo/css/safari.css');
document.getElementsByTagName('head')[0].appendChild(link);
}
});

