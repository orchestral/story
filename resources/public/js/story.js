!function e(t,n,r){function i(o,l){if(!n[o]){if(!t[o]){var s="function"==typeof require&&require;if(!l&&s)return s(o,!0);if(u)return u(o,!0);var a=new Error("Cannot find module '"+o+"'");throw a.code="MODULE_NOT_FOUND",a}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return i(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}for(var u="function"==typeof require&&require,o=0;o<r.length;o++)i(r[o]);return i}({1:[function(e,t,n){"use strict";function r(e){return e&&e.__esModule?e:{"default":e}}function i(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var u=function(){function e(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,n,r){return n&&e(t.prototype,n),r&&e(t,r),t}}(),o=e("./vendor/simplemde"),l=r(o),s=e("./vendor/jquery"),a=r(s),f=function(){function e(){i(this,e)}return u(e,[{key:"markdown",value:function(){var e=(0,a["default"])("textarea");if(e.size()>0){var t=new l["default"]({element:e[0],toolbar:["bold","italic","heading","|","quote","unordered-list","ordered-list","|","link","image","|","preview","guide"]});t.render()}return this}}]),e}();n["default"]=f},{"./vendor/jquery":3,"./vendor/simplemde":4}],2:[function(e,t,n){"use strict";function r(e){return e&&e.__esModule?e:{"default":e}}var i=e("./bootstrap"),u=r(i),o=window.Platform;o.extend("app","storycms",{data:function(){return{content:null,sluggable:!0,title:"",slug:""}},created:function(){$(function(){(new u["default"]).markdown()})},ready:function(){this.sluggable=!this.$get("content.id")>0,this.title=this.$get("content.title"),this.slug=this.slugify(this.$get("content.slug")||"","-")},methods:{slugify:function(e){var t=arguments.length<=1||void 0===arguments[1]?"-":arguments[1];return""==e?e:e.toLowerCase().replace(/^(_post_\/|_page_\/)/g,"").replace(/[^\w\.]+/g,t).replace(/\s+/g,t)},updateFromTitle:function(){""!=this.slug&&1!=this.sluggable||(this.slug=this.slugify(this.title,"-"))},updateFromSlug:function(){""==this.slug?this.slug=this.slugify(this.title,"-"):this.slug=this.slugify(this.slug,"-"),this.sluggable=!1}}})},{"./bootstrap":1}],3:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n["default"]=jQuery},{}],4:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n["default"]=SimpleMDE},{}]},{},[2]);