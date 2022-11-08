import{c as rt}from"./_commonjsHelpers.10c44588.js";var k={},ot={exports:{}};/*! https://mths.be/punycode v1.3.2 by @mathias */(function(t,r){(function(e){var c=r&&!r.nodeType&&r,a=t&&!t.nodeType&&t,l=typeof rt=="object"&&rt;(l.global===l||l.window===l||l.self===l)&&(e=l);var u,s=2147483647,p=36,m=1,v=26,M=38,g=700,f=72,C=128,z="-",w=/^xn--/,G=/[^\x20-\x7E]/,o=/[\x2E\u3002\uFF0E\uFF61]/g,x={overflow:"Overflow: input needs wider integers to process","not-basic":"Illegal input >= 0x80 (not a basic code point)","invalid-input":"Invalid input"},U=p-m,d=Math.floor,O=String.fromCharCode,B;function I(n){throw RangeError(x[n])}function q(n,h){for(var i=n.length,y=[];i--;)y[i]=h(n[i]);return y}function S(n,h){var i=n.split("@"),y="";i.length>1&&(y=i[0]+"@",n=i[1]),n=n.replace(o,".");var b=n.split("."),F=q(b,h).join(".");return y+F}function W(n){for(var h=[],i=0,y=n.length,b,F;i<y;)b=n.charCodeAt(i++),b>=55296&&b<=56319&&i<y?(F=n.charCodeAt(i++),(F&64512)==56320?h.push(((b&1023)<<10)+(F&1023)+65536):(h.push(b),i--)):h.push(b);return h}function et(n){return q(n,function(h){var i="";return h>65535&&(h-=65536,i+=O(h>>>10&1023|55296),h=56320|h&1023),i+=O(h),i}).join("")}function Z(n){return n-48<10?n-22:n-65<26?n-65:n-97<26?n-97:p}function X(n,h){return n+22+75*(n<26)-((h!=0)<<5)}function Y(n,h,i){var y=0;for(n=i?d(n/g):n>>1,n+=d(n/h);n>U*v>>1;y+=p)n=d(n/U);return d(y+(U+1)*n/(n+M))}function V(n){var h=[],i=n.length,y,b=0,F=C,A=f,R,T,N,$,j,_,L,K,J;for(R=n.lastIndexOf(z),R<0&&(R=0),T=0;T<R;++T)n.charCodeAt(T)>=128&&I("not-basic"),h.push(n.charCodeAt(T));for(N=R>0?R+1:0;N<i;){for($=b,j=1,_=p;N>=i&&I("invalid-input"),L=Z(n.charCodeAt(N++)),(L>=p||L>d((s-b)/j))&&I("overflow"),b+=L*j,K=_<=A?m:_>=A+v?v:_-A,!(L<K);_+=p)J=p-K,j>d(s/J)&&I("overflow"),j*=J;y=h.length+1,A=Y(b-$,y,$==0),d(b/y)>s-F&&I("overflow"),F+=d(b/y),b%=y,h.splice(b++,0,F)}return et(h)}function st(n){var h,i,y,b,F,A,R,T,N,$,j,_=[],L,K,J,nt;for(n=W(n),L=n.length,h=C,i=0,F=f,A=0;A<L;++A)j=n[A],j<128&&_.push(O(j));for(y=b=_.length,b&&_.push(z);y<L;){for(R=s,A=0;A<L;++A)j=n[A],j>=h&&j<R&&(R=j);for(K=y+1,R-h>d((s-i)/K)&&I("overflow"),i+=(R-h)*K,h=R,A=0;A<L;++A)if(j=n[A],j<h&&++i>s&&I("overflow"),j==h){for(T=i,N=p;$=N<=F?m:N>=F+v?v:N-F,!(T<$);N+=p)nt=T-$,J=p-$,_.push(O(X($+nt%J,0))),T=d(nt/J);_.push(O(X(T,0))),F=Y(i,K,y==b),i=0,++y}++i,++h}return _.join("")}function lt(n){return S(n,function(h){return w.test(h)?V(h.slice(4).toLowerCase()):h})}function pt(n){return S(n,function(h){return G.test(h)?"xn--"+st(h):h})}if(u={version:"1.3.2",ucs2:{decode:W,encode:et},decode:V,encode:st,toASCII:pt,toUnicode:lt},c&&a)if(t.exports==c)a.exports=u;else for(B in u)u.hasOwnProperty(B)&&(c[B]=u[B]);else e.punycode=u})(rt)})(ot,ot.exports);var mt={isString:function(t){return typeof t=="string"},isObject:function(t){return typeof t=="object"&&t!==null},isNull:function(t){return t===null},isNullOrUndefined:function(t){return t==null}},Q={};function yt(t,r){return Object.prototype.hasOwnProperty.call(t,r)}var dt=function(t,r,e,c){r=r||"&",e=e||"=";var a={};if(typeof t!="string"||t.length===0)return a;var l=/\+/g;t=t.split(r);var u=1e3;c&&typeof c.maxKeys=="number"&&(u=c.maxKeys);var s=t.length;u>0&&s>u&&(s=u);for(var p=0;p<s;++p){var m=t[p].replace(l,"%20"),v=m.indexOf(e),M,g,f,C;v>=0?(M=m.substr(0,v),g=m.substr(v+1)):(M=m,g=""),f=decodeURIComponent(M),C=decodeURIComponent(g),yt(a,f)?Array.isArray(a[f])?a[f].push(C):a[f]=[a[f],C]:a[f]=C}return a},H=function(t){switch(typeof t){case"string":return t;case"boolean":return t?"true":"false";case"number":return isFinite(t)?t:"";default:return""}},gt=function(t,r,e,c){return r=r||"&",e=e||"=",t===null&&(t=void 0),typeof t=="object"?Object.keys(t).map(function(a){var l=encodeURIComponent(H(a))+e;return Array.isArray(t[a])?t[a].map(function(u){return l+encodeURIComponent(H(u))}).join(r):l+encodeURIComponent(H(t[a]))}).join(r):c?encodeURIComponent(H(c))+e+encodeURIComponent(H(t)):""};Q.decode=Q.parse=dt;Q.encode=Q.stringify=gt;var xt=ot.exports,D=mt;k.parse=tt;k.resolve=Ut;k.resolveObject=qt;k.format=Ft;k.Url=P;function P(){this.protocol=null,this.slashes=null,this.auth=null,this.host=null,this.port=null,this.hostname=null,this.hash=null,this.search=null,this.query=null,this.pathname=null,this.path=null,this.href=null}var bt=/^([a-z0-9.+-]+:)/i,vt=/:[0-9]*$/,Ct=/^(\/\/?(?!\/)[^\?\s]*)(\?[^\s]*)?$/,Ot=["<",">",'"',"`"," ","\r",`
`,"	"],At=["{","}","|","\\","^","`"].concat(Ot),ht=["'"].concat(At),ft=["%","/","?",";","#"].concat(ht),ut=["/","?","#"],wt=255,ct=/^[+a-z0-9A-Z_-]{0,63}$/,It=/^([+a-z0-9A-Z_-]{0,63})(.*)$/,jt={javascript:!0,"javascript:":!0},at={javascript:!0,"javascript:":!0},E={http:!0,https:!0,ftp:!0,gopher:!0,file:!0,"http:":!0,"https:":!0,"ftp:":!0,"gopher:":!0,"file:":!0},it=Q;function tt(t,r,e){if(t&&D.isObject(t)&&t instanceof P)return t;var c=new P;return c.parse(t,r,e),c}P.prototype.parse=function(t,r,e){if(!D.isString(t))throw new TypeError("Parameter 'url' must be a string, not "+typeof t);var c=t.indexOf("?"),a=c!==-1&&c<t.indexOf("#")?"?":"#",l=t.split(a),u=/\\/g;l[0]=l[0].replace(u,"/"),t=l.join(a);var s=t;if(s=s.trim(),!e&&t.split("#").length===1){var p=Ct.exec(s);if(p)return this.path=s,this.href=s,this.pathname=p[1],p[2]?(this.search=p[2],r?this.query=it.parse(this.search.substr(1)):this.query=this.search.substr(1)):r&&(this.search="",this.query={}),this}var m=bt.exec(s);if(m){m=m[0];var v=m.toLowerCase();this.protocol=v,s=s.substr(m.length)}if(e||m||s.match(/^\/\/[^@\/]+@[^@\/]+/)){var M=s.substr(0,2)==="//";M&&!(m&&at[m])&&(s=s.substr(2),this.slashes=!0)}if(!at[m]&&(M||m&&!E[m])){for(var g=-1,f=0;f<ut.length;f++){var C=s.indexOf(ut[f]);C!==-1&&(g===-1||C<g)&&(g=C)}var z,w;g===-1?w=s.lastIndexOf("@"):w=s.lastIndexOf("@",g),w!==-1&&(z=s.slice(0,w),s=s.slice(w+1),this.auth=decodeURIComponent(z)),g=-1;for(var f=0;f<ft.length;f++){var C=s.indexOf(ft[f]);C!==-1&&(g===-1||C<g)&&(g=C)}g===-1&&(g=s.length),this.host=s.slice(0,g),s=s.slice(g),this.parseHost(),this.hostname=this.hostname||"";var G=this.hostname[0]==="["&&this.hostname[this.hostname.length-1]==="]";if(!G)for(var o=this.hostname.split(/\./),f=0,x=o.length;f<x;f++){var U=o[f];if(!!U&&!U.match(ct)){for(var d="",O=0,B=U.length;O<B;O++)U.charCodeAt(O)>127?d+="x":d+=U[O];if(!d.match(ct)){var I=o.slice(0,f),q=o.slice(f+1),S=U.match(It);S&&(I.push(S[1]),q.unshift(S[2])),q.length&&(s="/"+q.join(".")+s),this.hostname=I.join(".");break}}}this.hostname.length>wt?this.hostname="":this.hostname=this.hostname.toLowerCase(),G||(this.hostname=xt.toASCII(this.hostname));var W=this.port?":"+this.port:"",et=this.hostname||"";this.host=et+W,this.href+=this.host,G&&(this.hostname=this.hostname.substr(1,this.hostname.length-2),s[0]!=="/"&&(s="/"+s))}if(!jt[v])for(var f=0,x=ht.length;f<x;f++){var Z=ht[f];if(s.indexOf(Z)!==-1){var X=encodeURIComponent(Z);X===Z&&(X=escape(Z)),s=s.split(Z).join(X)}}var Y=s.indexOf("#");Y!==-1&&(this.hash=s.substr(Y),s=s.slice(0,Y));var V=s.indexOf("?");if(V!==-1?(this.search=s.substr(V),this.query=s.substr(V+1),r&&(this.query=it.parse(this.query)),s=s.slice(0,V)):r&&(this.search="",this.query={}),s&&(this.pathname=s),E[v]&&this.hostname&&!this.pathname&&(this.pathname="/"),this.pathname||this.search){var W=this.pathname||"",st=this.search||"";this.path=W+st}return this.href=this.format(),this};function Ft(t){return D.isString(t)&&(t=tt(t)),t instanceof P?t.format():P.prototype.format.call(t)}P.prototype.format=function(){var t=this.auth||"";t&&(t=encodeURIComponent(t),t=t.replace(/%3A/i,":"),t+="@");var r=this.protocol||"",e=this.pathname||"",c=this.hash||"",a=!1,l="";this.host?a=t+this.host:this.hostname&&(a=t+(this.hostname.indexOf(":")===-1?this.hostname:"["+this.hostname+"]"),this.port&&(a+=":"+this.port)),this.query&&D.isObject(this.query)&&Object.keys(this.query).length&&(l=it.stringify(this.query));var u=this.search||l&&"?"+l||"";return r&&r.substr(-1)!==":"&&(r+=":"),this.slashes||(!r||E[r])&&a!==!1?(a="//"+(a||""),e&&e.charAt(0)!=="/"&&(e="/"+e)):a||(a=""),c&&c.charAt(0)!=="#"&&(c="#"+c),u&&u.charAt(0)!=="?"&&(u="?"+u),e=e.replace(/[?#]/g,function(s){return encodeURIComponent(s)}),u=u.replace("#","%23"),r+a+e+u+c};function Ut(t,r){return tt(t,!1,!0).resolve(r)}P.prototype.resolve=function(t){return this.resolveObject(tt(t,!1,!0)).format()};function qt(t,r){return t?tt(t,!1,!0).resolveObject(r):r}P.prototype.resolveObject=function(t){if(D.isString(t)){var r=new P;r.parse(t,!1,!0),t=r}for(var e=new P,c=Object.keys(this),a=0;a<c.length;a++){var l=c[a];e[l]=this[l]}if(e.hash=t.hash,t.href==="")return e.href=e.format(),e;if(t.slashes&&!t.protocol){for(var u=Object.keys(t),s=0;s<u.length;s++){var p=u[s];p!=="protocol"&&(e[p]=t[p])}return E[e.protocol]&&e.hostname&&!e.pathname&&(e.path=e.pathname="/"),e.href=e.format(),e}if(t.protocol&&t.protocol!==e.protocol){if(!E[t.protocol]){for(var m=Object.keys(t),v=0;v<m.length;v++){var M=m[v];e[M]=t[M]}return e.href=e.format(),e}if(e.protocol=t.protocol,!t.host&&!at[t.protocol]){for(var x=(t.pathname||"").split("/");x.length&&!(t.host=x.shift()););t.host||(t.host=""),t.hostname||(t.hostname=""),x[0]!==""&&x.unshift(""),x.length<2&&x.unshift(""),e.pathname=x.join("/")}else e.pathname=t.pathname;if(e.search=t.search,e.query=t.query,e.host=t.host||"",e.auth=t.auth,e.hostname=t.hostname||t.host,e.port=t.port,e.pathname||e.search){var g=e.pathname||"",f=e.search||"";e.path=g+f}return e.slashes=e.slashes||t.slashes,e.href=e.format(),e}var C=e.pathname&&e.pathname.charAt(0)==="/",z=t.host||t.pathname&&t.pathname.charAt(0)==="/",w=z||C||e.host&&t.pathname,G=w,o=e.pathname&&e.pathname.split("/")||[],x=t.pathname&&t.pathname.split("/")||[],U=e.protocol&&!E[e.protocol];if(U&&(e.hostname="",e.port=null,e.host&&(o[0]===""?o[0]=e.host:o.unshift(e.host)),e.host="",t.protocol&&(t.hostname=null,t.port=null,t.host&&(x[0]===""?x[0]=t.host:x.unshift(t.host)),t.host=null),w=w&&(x[0]===""||o[0]==="")),z)e.host=t.host||t.host===""?t.host:e.host,e.hostname=t.hostname||t.hostname===""?t.hostname:e.hostname,e.search=t.search,e.query=t.query,o=x;else if(x.length)o||(o=[]),o.pop(),o=o.concat(x),e.search=t.search,e.query=t.query;else if(!D.isNullOrUndefined(t.search)){if(U){e.hostname=e.host=o.shift();var d=e.host&&e.host.indexOf("@")>0?e.host.split("@"):!1;d&&(e.auth=d.shift(),e.host=e.hostname=d.shift())}return e.search=t.search,e.query=t.query,(!D.isNull(e.pathname)||!D.isNull(e.search))&&(e.path=(e.pathname?e.pathname:"")+(e.search?e.search:"")),e.href=e.format(),e}if(!o.length)return e.pathname=null,e.search?e.path="/"+e.search:e.path=null,e.href=e.format(),e;for(var O=o.slice(-1)[0],B=(e.host||t.host||o.length>1)&&(O==="."||O==="..")||O==="",I=0,q=o.length;q>=0;q--)O=o[q],O==="."?o.splice(q,1):O===".."?(o.splice(q,1),I++):I&&(o.splice(q,1),I--);if(!w&&!G)for(;I--;I)o.unshift("..");w&&o[0]!==""&&(!o[0]||o[0].charAt(0)!=="/")&&o.unshift(""),B&&o.join("/").substr(-1)!=="/"&&o.push("");var S=o[0]===""||o[0]&&o[0].charAt(0)==="/";if(U){e.hostname=e.host=S?"":o.length?o.shift():"";var d=e.host&&e.host.indexOf("@")>0?e.host.split("@"):!1;d&&(e.auth=d.shift(),e.host=e.hostname=d.shift())}return w=w||e.host&&o.length,w&&!S&&o.unshift(""),o.length?e.pathname=o.join("/"):(e.pathname=null,e.path=null),(!D.isNull(e.pathname)||!D.isNull(e.search))&&(e.path=(e.pathname?e.pathname:"")+(e.search?e.search:"")),e.auth=t.auth||e.auth,e.slashes=e.slashes||t.slashes,e.href=e.format(),e};P.prototype.parseHost=function(){var t=this.host,r=vt.exec(t);r&&(r=r[0],r!==":"&&(this.port=r.substr(1)),t=t.substr(0,t.length-r.length)),t&&(this.hostname=t)};export{k as u};
