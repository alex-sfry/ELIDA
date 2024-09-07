yii.validation=(o=>{var l={isEmpty:function(e){return null==e||o.isArray(e)&&0===e.length||""===e},addMessage:function(e,a,t){e.push(a.replace(/\{value\}/g,t))},required:function(e,a,t){var s,n=!1;void 0===t.requiredValue?(s="string"==typeof e||e instanceof String,(t.strict&&void 0!==e||!t.strict&&!l.isEmpty(s?i(e):e))&&(n=!0)):(!t.strict&&e==t.requiredValue||t.strict&&e===t.requiredValue)&&(n=!0),n||l.addMessage(a,t.message,e)},boolean:function(e,a,t){t.skipOnEmpty&&l.isEmpty(e)||!t.strict&&(e==t.trueValue||e==t.falseValue)||t.strict&&(e===t.trueValue||e===t.falseValue)||l.addMessage(a,t.message,e)},string:function(e,a,t){t.skipOnEmpty&&l.isEmpty(e)||("string"!=typeof e?l.addMessage(a,t.message,e):void 0!==t.is&&e.length!=t.is?l.addMessage(a,t.notEqual,e):(void 0!==t.min&&e.length<t.min&&l.addMessage(a,t.tooShort,e),void 0!==t.max&&e.length>t.max&&l.addMessage(a,t.tooLong,e)))},file:function(e,t,s){e=a(e,t,s);o.each(e,function(e,a){r(a,t,s)})},image:function(e,s,n,i){e=a(e,s,n);o.each(e,function(e,a){var t;r(a,s,n),"undefined"!=typeof FileReader&&(t=o.Deferred(),l.validateImage(a,s,n,t,new FileReader,new Image),i.push(t))})},validateImage:function(n,i,r,o,e,l){l.onload=function(){var e=n,a=l,t=i,s=r;s.minWidth&&a.width<s.minWidth&&t.push(s.underWidth.replace(/\{file\}/g,e.name)),s.maxWidth&&a.width>s.maxWidth&&t.push(s.overWidth.replace(/\{file\}/g,e.name)),s.minHeight&&a.height<s.minHeight&&t.push(s.underHeight.replace(/\{file\}/g,e.name)),s.maxHeight&&a.height>s.maxHeight&&t.push(s.overHeight.replace(/\{file\}/g,e.name)),o.resolve()},l.onerror=function(){i.push(r.notImage.replace(/\{file\}/g,n.name)),o.resolve()},e.onload=function(){l.src=this.result},e.onerror=function(){o.resolve()},e.readAsDataURL(n)},number:function(e,a,t){t.skipOnEmpty&&l.isEmpty(e)||("string"!=typeof e||t.pattern.test(e)?(void 0!==t.min&&e<t.min&&l.addMessage(a,t.tooSmall,e),void 0!==t.max&&e>t.max&&l.addMessage(a,t.tooBig,e)):l.addMessage(a,t.message,e))},range:function(e,a,t){var s;t.skipOnEmpty&&l.isEmpty(e)||(!t.allowArray&&o.isArray(e)||(s=!0,o.each(o.isArray(e)?e:[e],function(e,a){return-1!=o.inArray(a,t.range)||(s=!1)}),void 0===t.not&&(t.not=!1),t.not===s))&&l.addMessage(a,t.message,e)},regularExpression:function(e,a,t){t.skipOnEmpty&&l.isEmpty(e)||(!t.not&&!t.pattern.test(e)||t.not&&t.pattern.test(e))&&l.addMessage(a,t.message,e)},email:function(e,a,t){var s,n,i;t.skipOnEmpty&&l.isEmpty(e)||null!==(s=/^((?:"?([^"]*)"?\s)?)(?:\s+)?(?:(<?)((.+)@([^>]+))(>?))$/.exec(e))&&(n=s[5],i=s[6],t.enableIDN&&(n=punycode.toASCII(n),i=punycode.toASCII(i),e=s[1]+s[3]+n+"@"+i+s[7]),!(64<n.length||254<(n+"@"+i).length))&&(t.pattern.test(e)||t.allowName&&t.fullPattern.test(e))||l.addMessage(a,t.message,e)},url:function(e,a,t){var s,n;t.skipOnEmpty&&l.isEmpty(e)||(t.defaultScheme&&!/:\/\//.test(e)&&(e=t.defaultScheme+"://"+e),s=!0,t.enableIDN&&(null===(n=/^([^:]+):\/\/([^\/]+)(.*)$/.exec(e))?s=!1:e=n[1]+"://"+punycode.toASCII(n[2])+n[3]),s&&t.pattern.test(e))||l.addMessage(a,t.message,e)},trim:function(e,a,t,s){e=e.find(a.input);if(!(e.is(":checkbox, :radio")||(s=e.val(),t.skipOnEmpty&&l.isEmpty(s))||t.skipOnArray&&Array.isArray(s))){if(Array.isArray(s))for(var n=0;n<s.length;n++)s[n]=i(s[n],t);else s=i(s,t);e.val(s)}return s},captcha:function(e,a,t){if(!t.skipOnEmpty||!l.isEmpty(e)){for(var s=null==(s=o("body").data(t.hashKey))?t.hash:s[t.caseSensitive?0:1],n=t.caseSensitive?e:e.toLowerCase(),i=n.length-1,r=0;0<=i;--i)r+=n.charCodeAt(i)<<i;r!=s&&l.addMessage(a,t.message,e)}},compare:function(e,a,t,s){if(!t.skipOnEmpty||!l.isEmpty(e)){var n,i,r=!0;switch(i=void 0===t.compareAttribute?t.compareValue:(n=(n=o("#"+t.compareAttribute)).length?n:s.find('[name="'+t.compareAttributeName+'"]')).val(),"number"===t.type&&(e=e?parseFloat(e):0,i=i?parseFloat(i):0),t.operator){case"==":r=e==i;break;case"===":r=e===i;break;case"!=":r=e!=i;break;case"!==":r=e!==i;break;case">":r=i<e;break;case">=":r=i<=e;break;case"<":r=e<i;break;case"<=":r=e<=i;break;default:r=!1}r||l.addMessage(a,t.message,e)}},ip:function(e,a,t){var s,n,i;t.skipOnEmpty&&l.isEmpty(e)||(n=s=null,(i=new RegExp(t.ipParsePattern).exec(e))&&(s=i[1]||null,e=i[2],n=i[4]||null),!0===t.subnet&&null===n?l.addMessage(a,t.messages.noSubnet,e):!1===t.subnet&&null!==n?l.addMessage(a,t.messages.hasSubnet,e):!1===t.negation&&null!==s?l.addMessage(a,t.messages.message,e):6==(-1===e.indexOf(":")?4:6)?(new RegExp(t.ipv6Pattern).test(e)||l.addMessage(a,t.messages.message,e),t.ipv6||l.addMessage(a,t.messages.ipv6NotAllowed,e)):(new RegExp(t.ipv4Pattern).test(e)||l.addMessage(a,t.messages.message,e),t.ipv4||l.addMessage(a,t.messages.ipv4NotAllowed,e)))}};function a(e,a,t){return"undefined"==typeof File||void 0===(e=o(e.input,e.$form).get(0))?[]:(e=e.files)?0===e.length?(t.skipOnEmpty||a.push(t.uploadRequired),[]):t.maxFiles&&t.maxFiles<e.length?(a.push(t.tooMany),[]):e:(a.push(t.message),[])}function r(e,a,t){if(t.extensions&&0<t.extensions.length){for(var s=!1,n=e.name.toLowerCase(),i=0;i<t.extensions.length;i++){var r=t.extensions[i].toLowerCase();if(""===r&&-1===n.indexOf(".")||n.substr(n.length-t.extensions[i].length-1)==="."+r){s=!0;break}}s||a.push(t.wrongExtension.replace(/\{file\}/g,e.name))}t.mimeTypes&&0<t.mimeTypes.length&&(((e,a)=>{for(var t=0,s=e.length;t<s;t++)if(new RegExp(e[t]).test(a))return 1})(t.mimeTypes,e.type)||a.push(t.wrongMimeType.replace(/\{file\}/g,e.name))),t.maxSize&&t.maxSize<e.size&&a.push(t.tooBig.replace(/\{file\}/g,e.name)),t.minSize&&t.minSize>e.size&&a.push(t.tooSmall.replace(/\{file\}/g,e.name))}function i(e,a={skipOnEmpty:!0,chars:null}){return!1!==a.skipOnEmpty&&l.isEmpty(e)?e:(e=new String(e),a.chars||!String.prototype.trim?(a=a.chars?a.chars.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g,"$1"):" \\s ",e.replace(new RegExp("^["+a+"]+|["+a+"]+$","g"),"")):e.trim())}return l})(jQuery);
//# sourceMappingURL=yii.validation.js.map
