requirejs.config({
    "baseUrl": "../scripts/lib",
    "paths": {
      "app": "../app",
	  "lib": "../lib",
	  "core": "../core",
	  "controls": "../controls",
	  "utils":"../utils",
	  "jquery":"../lib/jquery",
	  "jquery-ui":"../lib/jquery-ui",
	  "slick":"../controls/slick"
    },
    "shim": {
		"jquery-ui": {
			deps:['jquery']
		}
    },
	 map: {
      '*': {
        'css': '../css/css'
      } 
    }
});
