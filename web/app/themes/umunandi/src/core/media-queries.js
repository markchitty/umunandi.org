umunandi.define('common', 5, function() {

  // JS media queries
  umunandi.screenSize = {

    // copied from src/core/less/variables.less
    sizes: {
      xs: 480,
      sm: 768,
      md: 992,
      lg: 1200
    },

    getSize: function(size) {
      if (size in umunandi.screenSize.sizes) return umunandi.screenSize.sizes[size];
      if (isNaN(size)) return 1;
      return size;
    },

    isAtLeast: function(size) {
      return window.matchMedia('(min-width: ' + this.getSize(size) + 'px)').matches;
    },

    isUpTo: function(size) {
      return window.matchMedia('(max-width: ' + (this.getSize(size) - 1) + 'px)').matches;
    },

    updateSizes: function() {
      this.isAtLeastXs = this.isAtLeast('xs');
      this.isAtLeastSm = this.isAtLeast('sm');
      this.isAtLeastMd = this.isAtLeast('md');
      this.isAtLeastLg = this.isAtLeast('lg');
    }
  };
  
});
