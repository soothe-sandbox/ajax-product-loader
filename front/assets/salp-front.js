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
 * # Layout
 * ============================== */

/*
 * # Layout - Elements
 */
sapl.layout = {
  $container : wpSapl.container? wpSapl.container: jQuery('ul.products'),
  $trigger   : jQuery('.sapl-scroll-trigger'),
  $loader    : jQuery('.sapl-scroll-loader'),
  prdClass   : 'm-salp-product-new',
  prdClassDot: '.m-salp-product-new',
}
sapl.layout.$container.addClass('sapl-container');

/*
 * # Layout - Check if Request is in process
 */
sapl.layout.isInProcess = function()
{
  console.log('Status: ' + this.$container.hasClass('loading'));

  return this.$container.hasClass('loading');
}

/*
 * # Layout - Load More
 */
sapl.layout.add = function(postsNew)
{
  console.log('Layout - Add');

  // Add class-state
  $posts = jQuery(postsNew).addClass(this.prdClass);

  // Append New Products
  this.$container.append($posts);

  // Init Animation
  anime(this.animation);

  // Remove class-state
  this.$container.find(this.prdClassDot)
    .removeClass(this.prdClass);
}

/*
 * # Layout - Loading
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
 * # Layout - Loaded
 */
sapl.layout.loaded = function(res)
{
  // if Type - Scroll
  if(sapl.model.getType()){
    this.$loader.fadeOut(300);
    this.$container.removeClass('loading');
  }

  sapl.layout.add(res.posts_data);
}

/*
 * # Layout - Animation
 */
sapl.layout.animation = {
  duration: function(t,i) {
    return 500 + i*50;
  },
  easing: 'easeOutExpo',
  delay: function(t,i) {
    return i * 20;
  },
  opacity: {
    value: [0,1],
    duration: function(t,i) {
      return 250 + i*50;
    },
    easing: 'linear'
  },
  translateY: [400,0],
  targets: sapl.layout.prdClassDot,
}

/* ==============================
 * # REQUEST
 * ============================== */
sapl.request = { }

/*
 * # Request - Base
 */
sapl.request.base = function(req, cb)
{
  // Debug
  console.log('Request is in process..');

  jQuery.post(wpSapl.ajaxUrl, req, cb);
}

/*
 * # Request - Simple
 */
sapl.request.simple = function()
{
  // Debug
  console.log('Request - Simple - Begin');

  // Check if Request already in process
  if(sapl.layout.isInProcess()) return;

  // Set Request data
  sapl.model.requestArgs.page  += 1;
  sapl.model.requestArgs.catId  = false;
  sapl.model.requestArgs.catNew = false;

  // Set Action name
  var req = {
    action: 'sapl_request_simple',
    data: sapl.model.requestArgs,
  }

  // Set Status 'Loading'
  sapl.layout.loading();

  // Init Request
  this.base(req, this.simpleCallback);
}

sapl.request.simpleCallback = function(res)
{
  // Debug
  console.log('Request - Simple - Callback');
  console.log(res);

  sapl.layout.loaded(res);
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
    // console.log(pos);
    // console.log(trgOffTop);

    if( pos>=trgOffTop &&
        !sapl.layout.$container.hasClass('loading')
    ){
      sapl.request.simple();
    }
  })
}