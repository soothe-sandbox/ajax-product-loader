// Globals
var
  $window = jQuery(window);
  sapl    = { }

/* ==============================
 * # MODEL
 * ============================== */
sapl.model = { }

/*
 * # Model - Settings
 */
sapl.model.settings = {
  type: wpSapl.type,
}

/*
 * # Model - Request Arguments
 */
sapl.model.requestArgs = {
  ppp   : wpSapl.ppp,
  page  : 1,
  catId : false,
  catNew: false,
}

sapl.model.getType = function()
{
  if( sapl.model.settings.type==='button' ){
    return false;
  } else if(sapl.model.settings.type==='scroll'){
    return true;
  }
}

/* ==============================
 * # DOM
 * ============================== */

/*
 * # Dom - Elements
 */
sapl.layout = {
  $container: wpSapl.container? wpSapl.container: jQuery('ul.products'),
  $trigger  : jQuery('.sapl-scroll-trigger'),
  $loader   : jQuery('.sapl-scroll-loader'),
}
sapl.layout.$container.addClass('sapl-container');

/*
 * # Dom - Load More
 */
sapl.layout.add = function()
{
  console.log('Layout - Add');
}

/*
 * # Dom - Loading
 */
sapl.layout.loading = function()
{
  // if Type - Scroll
  if(sapl.model.getType()){
    this.$loader.fadeIn(300);
    this.$container.addClass('loading');
  }
}

/*
 * # Dom - Loaded
 */
sapl.layout.loaded = function()
{
  // if Type - Scroll
  if(sapl.model.getType()){
    this.$loader.fadeOut(300);
    this.$container.removeClass('loading');
  }
}

/* ==============================
 * # REQUEST
 * ============================== */
sapl.request = { }

/*
 * # Request - Base
 */
sapl.request.base = function(cb)
{
  jQuery.post(wpSapl.ajaxUrl, data, cb);
}

/*
 * # Request - Simple
 */
sapl.request.simple = function()
{
  // Set Request data
  sapl.model.requestArgs.page  += 1;
  sapl.model.requestArgs.catId  = false;
  sapl.model.requestArgs.catNew = false;

  // Set Action name
  var data = {
    action: 'sapl_request_simple',
    data: sapl.model.requestArgs,
  }

  // Set Status 'Loading'
  sapl.layout.loading();

  // Init Request
  this.base(this.simpleCallback);
}

sapl.request.simpleCallback = function(res)
{
  sapl.layout.loaded();
}


/*
 * # Type - Scroll
 */
if(sapl.model.getType()){
  $window.on('scroll', ()=>{
    var
      pos       = $window.scrollTop() + $window.height();
      trgOffTop = sapl.layout.$trigger.offset().top;

    // Debug
    console.log(pos);
    console.log(trgOffTop);

    if( pos>=trgOffTop &&
        !sapl.layout.$container.hasClass('loading')
    ){
      sapl.request.simple();
    }
  })
}