/*!
 * Tipped - The jQuery Tooltip - v3.1.0.1
 * (c) 2010-2012 Nick Stakenburg
 *
 * http://projects.nickstakenburg.com/tipped
 *
 * License: http://projects.nickstakenburg.com/tipped/license
 */
;var Tipped = { version: '3.1.0.1' };

Tipped.Skins = {
  // base skin, don't modify! (create custom skins in a separate file)
  'base': {
    afterUpdate: false,
    ajax: {
      cache: true,
      type: 'get'
    },
    background: {
      color: '#f2f2f2',
      opacity: 1
    },
    border: {
      size: 1,
      color: '#000',
      opacity: 1
    },
    closeButtonSkin: 'default',
    containment: {
      selector: 'viewport'
    },
    fadeIn: 180,
    fadeOut: 220,
    showDelay: 75,
    hideDelay: 25,
    radius: {
      size: 5,
      position: 'background'
    },
    hideAfter: false,
    hideOn: {
      element: 'self',
      event: 'mouseleave'
    },
    hideOthers: false,
    hook: 'topleft',
    inline: false,
    offset: { x: 0, y: 0 },
    onHide: false,
    onShow: false,
    shadow: {
      blur: 2,
      color: '#000',
      offset: { x: 0, y: 0 },
      opacity: .12
    },
    showOn: 'mousemove',
    spinner: true,
    stem: {
      height: 9,
      width: 18,
      offset: { x: 9, y: 9 },
      spacing: 2
    },
    target: 'self'
  },
  
  // Every other skin inherits from this one
  'reset': {
    ajax: false,
    closeButton: false,
    hideOn: [{
      element: 'self',
      event: 'mouseleave'
    }, {
      element: 'tooltip',
      event: 'mouseleave'
    }],
    hook: 'topmiddle',
    stem: true
  },
  
  'dark': {
    background: { color: '#282828' },
    border: { color: '#9b9b9b', opacity: .4, size: 1 },
    shadow: { opacity: .02 },
    spinner: { color: '#fff' }
  },
  'cloud': {
    border: {
      size: 1,
      color: [
        { position: 0, color: '#bec6d5'},
        { position: 1, color: '#b1c2e3' }
      ]
    },
    closeButtonSkin: 'light',


    background: {
      color: [
        { position: 0, color: '#f6fbfd'},
        { position: 0.1, color: '#fff' },
        { position: .48, color: '#fff'},
        { position: .5, color: '#fefffe'},
        { position: .52, color: '#f7fbf9'},
        { position: .8, color: '#edeff0' },
        { position: 1, color: '#e2edf4' }
      ]
    },

    shadow: { opacity: .1 }
  },
  
  'light': {
    background: { color: '#fff' },
    border: { color: '#646464', opacity: .4, size: 1 },
    shadow: { opacity: .04 }
  },
  
  'gray': {
    background: {
      color: [
        { position: 0, color: '#8f8f8f'},
        { position: 1, color: '#808080' }
      ]
    },
    border: { color: '#131313', size: 1, opacity: .6 } 
  },
  
  'tiny': {
    background: { color: '#000', opacity: .8 },
    border: 0,
    fadeIn: 0,
    fadeOut: 0,
    radius: 4,
    stem: {
      width: 11,
      height: 6,
      offset: { x: 6, y: 6 }
    },
    shadow: false,
    spinner: { color: '#fff' }
  },

  'yellow': {
    background: '#ffffaa',
    border: { size: 1, color: '#6d5208', opacity: .4 }
  },
  
  'red': {
    background: {
      color: [
        { position: 0, color: '#e13c37'},
        { position: 1, color: '#e13c37' }
      ]
    },
    border: { size: 1, color: '#150201', opacity: .6 },
    spinner: { color: '#fff' }
  },
  
  'green': {
    background: {
      color: [
        { position: 0, color: '#4bb638'},
        { position: 1, color: '#4aab3a' }
      ]
    },
    border: { size: 1, color: '#122703', opacity: .6 },
    spinner: { color: '#fff' }
  },

  'blue': {
    background: {
      color: [
        { position: 0, color: '#4588c8'},
        { position: 1, color: '#3d7cb9' }
      ]
    },
    border: { color: '#020b17', opacity: .6 },
    spinner: { color: '#fff' }
  }
};


/* black and white are dark and light without radius */
(function($) {
  $.extend(Tipped.Skins, {
    black: $.extend(true, {}, Tipped.Skins.dark, { radius: 0 }),
    white: $.extend(true, {}, Tipped.Skins.light, { radius: 0 })
  });
})(jQuery);

Tipped.Skins.CloseButtons = {
  'base': {
    diameter: 17,
    border: 2,
    x: { diameter: 10, size: 2, opacity: 1 },
    states: {
      'default': {
        background: {
          color: [
            { position: 0, color: '#1a1a1a' },
            { position: 0.46, color: '#171717' },
            { position: 0.53, color: '#121212' },
            { position: 0.54, color: '#101010' },
            { position: 1, color: '#000' }
          ],
          opacity: 1
        },
        x: { color: '#fafafa', opacity: 1 },
        border: { color: '#fff', opacity: 1 }
      },
      'hover': {
        background: {
          color: '#333',
          opacity: 1
        },
        x: { color: '#e6e6e6', opacity: 1 },
        border: { color: '#fff', opacity: 1 }
      }
    },
    shadow: {
      blur: 1,
      color: '#000',
      offset: { x: 0, y: 0 },
      opacity: .5
    }
  },

  'reset': {},

  'default': {},

  'light': {
    diameter: 17,
    border: 2,
    x: { diameter: 10, size: 2, opacity: 1 },
    states: {
      'default': {
        background: {
          color: [
            { position: 0, color: '#797979' },
            { position: 0.48, color: '#717171' },
            { position: 0.52, color: '#666' },
            { position: 1, color: '#666' }
          ],
          opacity: 1
        },
        x: { color: '#fff', opacity: .95 },
        border: { color: '#676767', opacity: 1 }
      },
      'hover': {
        background: {
          color: [
            { position: 0, color: '#868686' },
            { position: 0.48, color: '#7f7f7f' },
            { position: 0.52, color: '#757575' },
            { position: 1, color: '#757575' }
          ],
          opacity: 1
        },
        x: { color: '#fff', opacity: 1 },
        border: { color: '#767676', opacity: 1 }
      }
    }
  }
};


eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(K(e){K n(e,t){R n=[e,t];15 n.12=e,n.13=t,n}K s(e){!1I.5p||5p[5p.6q?"6q":"86"](e)}K a(e){J.1e=e}K f(e){R t={};2k(R n 5q e)t[n]=e[n]+"2r";15 t}K l(e,t){15 19.6r(e*e+t*t)}K c(e){15 e*2C/19.2W}K h(e){15 e*19.2W/2C}K p(e){15 1/19.4t(e)}K w(t){18(!t)15;J.1e=t,b.1z(t);R n=J.26();J.17=e.1i({},n.17),J.2s=1,J.1n={},J.1R=e(t).1W("2l-1R"),b.2X(J),J.23=J.17.1q.1A,J.6s=J.17.1h&&J.23,J.38={x:0,y:0},J.3i={13:0,12:0},J.1L()}K S(t,n){J.1e=t;18(!J.1e||!n)15;J.17=e.1i({2Y:3,1w:{x:0,y:0},1M:"#4u",1G:.5,2K:1},1Y[2]||{}),J.2s=J.17.2K,J.1n={},J.1R=e(t).1W("2l-1R"),E.2X(J),J.1L()}K T(t){J.1e=t;18(!J.1e)15;J.17=e.1i({2Y:5,1w:{x:0,y:0},1M:"#4u",1G:.5,2K:1},1Y[1]||{}),J.2s=J.17.2K,J.1R=e(t).1W("2l-1R"),x.2X(J),J.1L()}K N(t,n){2k(R r 5q n)n[r]&&n[r].3y&&n[r].3y===5r?(t[r]=e.1i({},t[r])||{},N(t[r],n[r])):t[r]=n[r];15 t}K k(t,n){J.1e=t;18(!J.1e)15;R i=e(t).1W("2l-1R");i&&C.1z(t),i=u(),e(t).1W("2l-1R",i),J.1R=i;R s;e.1m(n)=="87"&&!r.2h(n)?(s=n,n=1p):s=1Y[2]||{},J.17=C.6t(s);R o=t.6u("5s");18(!n){R a=t.6u("1W-2l");a?n=a:o&&(n=o)}o&&(e(t).1W("5t",o),t.88("5s","")),J.2D=n,J.2e=J.17.2e||+C.17.4v,J.1n={2E:{11:1,14:1},5u:[],39:[],2m:{4w:!1,2t:!1,1J:!1,3j:!1,1L:!1,4x:!1,5v:!1,3z:!1},5w:""};R f=J.17.1x;J.1x=f=="2L"?"2L":f=="4y"||!f?J.1e:f&&1t.6v(f)||J.1e,J.6w(),C.2X(J)}R t=6x.3A.89,r={8a:K(n,r){R i=n;15 K(){R n=[e.1s(i,J)].6y(t.5x(1Y));15 r.5y(J,n)}},2h:K(e){15 e&&e.8b==1},4z:K(e,n){R r=t.5x(1Y,2);15 8c(K(){15 e.5y(e,r)},n)},3X:K(e){15 r.4z.5y(J,[e,1].6y(t.5x(1Y,1)))},5z:K(e){15{x:e.5A,y:e.6z}},1e:{4A:K(e){R t=0,r=0;8d t+=e.4B||0,r+=e.4C||0,e=e.4D;5B(e);15 n(r,t)},4E:K(t){R i=e(t).1w(),s=r.1e.4A(t),o={13:e(1I).4B(),12:e(1I).4C()};15 i.12+=s.12-o.12,i.13+=s.13-o.13,n(i.12,i.13)},5C:K(){K e(e){R t=e;5B(t&&t.4D)t=t.4D;15 t}15 K(t){R n=e(t);15!!n&&!!n.3a}}()}},i=K(e){K t(t){R n=(2F 5D(t+"([\\\\d.]+)")).8e(e);15 n?5E(n[1]):!0}15{3k:!!1I.8f&&e.3l("5F")===-1&&t("8g "),5F:e.3l("5F")>-1&&(!!1I.5G&&5G.6A&&5E(5G.6A())||7.55),5H:e.3l("6B/")>-1&&t("6B/"),4F:e.3l("4F")>-1&&e.3l("8h")===-1&&t("8i:"),6C:!!e.3b(/8j.*8k.*8l/),4G:e.3l("4G")>-1&&t("4G/")}}(8m.8n),o={2Z:{3Y:{5I:"1.4.4",5J:1I.3Y&&3Y.8o.8p}},6D:K(){K t(t){R n=t.3b(e),r=n&&n[1]&&n[1].30(".")||[],i=0;2k(R s=0,o=r.2f;s<o;s++)i+=2M(r[s]*19.4H(10,6-s*2));15 n&&n[3]?i-1:i}R e=/^(\\d+(\\.?\\d+){0,3})([A-6E-8q-]+[A-6E-8r-9]+)?/;15 K(n){18(J.2Z[n].6F)15;J.2Z[n].6F=!0;18(!J.2Z[n].5J||t(J.2Z[n].5J)<t(J.2Z[n].5I)&&!J.2Z[n].6G)J.2Z[n].6G=!0,s("1T 8s "+n+" >= "+J.2Z[n].5I)}}()},u=K(){R e=0,t="8t";15 K(n){n=n||t,e++;5B(1t.6v(n+e))e++;15 n+e}}();e.1i(1T,K(){15{31:{3c:K(){R e=1t.1Z("3c");15!!e.3m&&!!e.3m("2d")}(),4I:K(){6H{15!!("8u"5q 1I||1I.6I&&1t 8v 6I)}6J(e){15!1}}(),3Z:K(){R t=["8w","8x","8y"],n=!1;15 e.1u(t,K(e,t){6H{1t.8z(t),n=!0}6J(r){}}),n}()},3n:K(){18(!J.31.3c&&!i.3k)15;o.6D("3Y"),e(1t).6K(K(){C.6L()})},4J:K(e,t,n){15 a.4J(e,t,n),J.1r(e)},1r:K(e){15 2F a(e)},5K:K(e){15 C.5K(e)},1S:K(e){15 J.1r(e).1S(),J},1F:K(e){15 J.1r(e).1F(),J},32:K(e){15 J.1r(e).32(),J},2N:K(e){15 J.1r(e).2N(),J},1z:K(e){15 J.1r(e).1z(),J},4K:K(){15 C.4K(),J},5L:K(e){15 C.5L(e),J},5M:K(e){15 C.5M(e),J},1J:K(t){18(r.2h(t))15 C.5N(t);18(e.1m(t)!="5O"){R n=e(t),i=0;15 e.1u(n,K(e,t){C.5N(t)&&i++}),i}15 C.3B().2f}}}()),e.1i(a,{4J:K(t,n){18(!t)15;R i=1Y[2]||{},s=[];15 C.6M(),r.2h(t)?s.2n(2F k(t,n,i)):e(t).1u(K(e,t){s.2n(2F k(t,n,i))}),s}}),e.1i(a.3A,{40:K(){15 C.2u.4L={x:0,y:0},C.1r(J.1e)},1S:K(){15 e.1u(J.40(),K(e,t){t.1S()}),J},1F:K(){15 e.1u(J.40(),K(e,t){t.1F()}),J},32:K(){15 e.1u(J.40(),K(e,t){t.32()}),J},2N:K(){15 e.1u(J.40(),K(e,t){t.2N()}),J},1z:K(){15 C.1z(J.1e),J}});R d={4M:K(){R t;15 i.6C?t={11:1I.5P,14:1I.5Q}:t={14:e(1I).14(),11:e(1I).11()},t}},v={3o:19.1B(19.4N(1I.3o?5E(1I.3o)||1:1,2)),3n:K(){K e(e){R t=e.3m("2d");t.8A(v.3o,v.3o)}15 1I.4O&&!1T.31.3c&&i.3k?K(t){4O.8B(t),e(t)}:K(t){e(t)}}(),3C:K(t,n){e(t).3d({11:n.11*J.3o,14:n.14*J.3o}).1l(f(n))},6N:K(t){R n=e.1i({13:0,12:0,11:0,14:0,1k:0},1Y[1]||{}),r=n,i=r.12,s=r.13,o=r.11,u=r.14,a=r.1k;18(!a){t.6O(i,s,o,u);15}t.27(),t.3p(i+a,s),t.22(i+o-a,s+a,a,h(-90),h(0),!1),t.22(i+o-a,s+u-a,a,h(0),h(90),!1),t.22(i+a,s+u-a,a,h(90),h(2C),!1),t.22(i+a,s+a,a,h(-2C),h(-90),!1),t.28(),t.33()},8C:K(t,n){R r=e.1i({x:0,y:0,1M:"#4u"},1Y[2]||{});2k(R i=0,s=n.2f;i<s;i++)2k(R o=0,u=n[i].2f;o<u;o++){R a=2M(n[i].3q(o))*(1/9);t.2O=y.2P(r.1M,a),a&&t.6O(r.x+o,r.y+i,1,1)}},41:K(t,n){R r;18(e.1m(n)=="2o")r=y.2P(n);1C 18(e.1m(n.1M)=="2o")r=y.2P(n.1M,e.1m(n.1G)=="2v"?n.1G:1);1C 18(e.6P(n.1M)){R i=e.1i({3D:0,3E:0,3F:0,3G:0},1Y[2]||{});r=v.6Q.6R(t.8D(i.3D,i.3E,i.3F,i.3G),n.1M,n.1G)}15 r}};v.6Q={6R:K(t,n){R r=e.1m(1Y[2])=="2v"?1Y[2]:1;2k(R i=0,s=n.2f;i<s;i++){R o=n[i];18(e.1m(o.1G)=="5O"||e.1m(o.1G)!="2v")o.1G=1;t.8E(o.1c,y.2P(o.1M,o.1G*r))}15 t}};R m={6S:["3H","42","3I","3J","43","44","46","47","48","49","4a","3K"],4b:{6T:/^(13|12|1O|1N)(13|12|1O|1N|2w|2Q)$/,1K:/^(13|1O)/,34:/(2w|2Q)/,6U:/^(13|1O|12|1N)/},6V:K(){R e={13:"14",12:"11",1O:"14",1N:"11"};15 K(t){15 e[t]}}(),34:K(e){15!!e.3r().3b(J.4b.34)},6W:K(e){15!J.34(e)},2G:K(e){15 e.3r().3b(J.4b.1K)?"1K":"2i"},5R:K(e){R t=1p,n=e.3r().3b(J.4b.6U);15 n&&n[1]&&(t=n[1]),t},30:K(e){15 e.3r().3b(J.4b.6T)}},g={5S:K(e){R t=e.17.1h;15{11:t.11,14:t.14}},4c:K(t,n){R r=e.1i({3L:"1B"},1Y[2]||{}),i=t.17.1h,s=i.11,o=i.14,u=J.4P(s,o,n);15 r.3L&&(u.11=19[r.3L](u.11),u.14=19[r.3L](u.14)),{11:u.11,14:u.14}},4P:K(e,t,n){R r=c(19.6X(t/e*.5)),i=2C-r,s=19.4t(h(i-90))*n,o=e+s*2,u=o*t/e;15{11:o,14:u}},3M:K(e,t){R n=J.4c(e,t),r=J.5S(e),i=m.34(e.23),s=19.1B(n.14+t),o=e.17.1h.1w||0,u=e.17.1k&&e.17.1k.2p||0;15{2x:{1a:{11:19.1B(n.11),14:19.1B(s)}},1f:{1a:n},1h:{1a:{11:r.11,14:r.14}}}},5T:K(t,n,r){R i={},s=t.17,o={13:0,12:0},u={13:0,12:0},a=e.1i({},n),f=t.1f,l=l||J.3M(t,t.1f),c=l.2x.1a;r&&(c.14=r,f=0);R h=m.30(t.23),p=m.2G(t.23);18(t.17.1h){R d=m.5R(t.23);d=="13"?o.13=c.14-f:d=="12"&&(o.12=c.14-f);18(p=="1K"){1P(h[2]){1d"2w":1d"2Q":u.12=.5*a.11;1y;1d"1N":u.12=a.11}h[1]=="1O"&&(u.13=a.14-f+c.14)}1C{1P(h[2]){1d"2w":1d"2Q":u.13=.5*a.14;1y;1d"1O":u.13=a.14}h[1]=="1N"&&(u.12=a.11-f+c.14)}a[m.6V(d)]+=c.14-f}1C 18(p=="1K"){1P(h[2]){1d"2w":1d"2Q":u.12=.5*a.11;1y;1d"1N":u.12=a.11}h[1]=="1O"&&(u.13=a.14)}1C{1P(h[2]){1d"2w":1d"2Q":u.13=.5*a.14;1y;1d"1O":u.13=a.14}h[1]=="1N"&&(u.12=a.11)}R v=s.1k&&s.1k.2p||0,y=s.1f&&s.1f.2p||0;18(t.17.1h){R b=v&&s.1k.1c=="1j"?v:0,w=v&&s.1k.1c=="1f"?v:v+y,E=y+b+.5*l.1h.1a.11-.5*l.1f.1a.11,S=w>E?w-E:0,x=19.1B(y+b+.5*l.1h.1a.11+S);18(p=="1K")1P(h[2]){1d"12":u.12+=x;1y;1d"1N":u.12-=x}1C 1P(h[2]){1d"13":u.13+=x;1y;1d"1O":u.13-=x}}R T;18(s.1h&&(T=s.1h.1w)){R N=g.5U(T,t.6s,n,l.1f.1a,y,v);T=N.1w;R C=N.4d;18(p=="1K")1P(h[2]){1d"12":u.12+=T.x;1y;1d"1N":u.12-=T.x}1C 1P(h[2]){1d"13":u.13+=T.y;1y;1d"1O":u.13-=T.y}}R k;18(s.1h&&(k=s.1h.8F))18(p=="1K")1P(h[1]){1d"13":u.13-=k;1y;1d"1O":u.13+=k}1C 1P(h[1]){1d"12":u.12-=k;1y;1d"1N":u.12+=k}15{1a:a,1c:{13:0,12:0},1j:{1c:o,1a:n},1h:{1a:c},2H:u}},5U:K(t,n,r,i,s,o){R u=m.2G(n),a=e.1i({},t),f={x:0,y:0};15 u=="1K"&&r.11-i.11-2*s-2*o<2*t.x&&(f.x=a.x,a.x=0),u=="2i"&&r.14-i.14-2*s-2*o<2*t.y&&(f.y=a.y,a.y=0),{1w:a,4d:f}}},y=K(){K r(e){R t=e;15 t.6Y=e[0],t.6Z=e[1],t.70=e[2],t}K i(e){15 2M(e,16)}K s(e){R t=2F 6x(3);e.3l("#")==0&&(e=e.4Q(1)),e=e.3r();18(e.5V(n,"")!="")15 1p;e.2f==3?(t[0]=e.3q(0)+e.3q(0),t[1]=e.3q(1)+e.3q(1),t[2]=e.3q(2)+e.3q(2)):(t[0]=e.4Q(0,2),t[1]=e.4Q(2,4),t[2]=e.4Q(4));2k(R s=0;s<t.2f;s++)t[s]=i(t[s]);15 r(t)}K o(e,t){R n=s(e);15 n[3]=t,n.1G=t,n}K u(t,n){15 e.1m(n)=="5O"&&(n=1),"8G("+o(t,n).8H()+")"}K a(e){15"#"+(f(e)[2]>50?"4u":"8I")}K f(e){15 l(s(e))}K l(e){R e=r(e),t=e.6Y,n=e.6Z,i=e.70,s,o,u,a=t>n?t:n;i>a&&(a=i);R f=t<n?t:n;i<f&&(f=i),u=a/8J,o=a!=0?(a-f)/a:0;18(o==0)s=0;1C{R l=(a-t)/(a-f),c=(a-n)/(a-f),h=(a-i)/(a-f);t==a?s=h-c:n==a?s=2+l-h:s=4+c-l,s/=6,s<0&&(s+=1)}s=19.20(s*71),o=19.20(o*5W),u=19.20(u*5W);R p=[];15 p[0]=s,p[1]=o,p[2]=u,p.8K=s,p.8L=o,p.8M=u,p}R t="8N",n=2F 5D("["+t+"]","g");15{8O:s,2P:u,8P:a}}(),b={4R:{},1r:K(t){18(!t)15 1p;R n=1p,r=e(t).1W("2l-1R");15 r&&(n=J.4R[r]),n},2X:K(e){J.4R[e.1R]=e},1z:K(e){R t=J.1r(e);t&&(4e J.4R[t.1R],t.1z())}};e.1i(w.3A,K(){K t(){J.1n.1q={};R t=J.23;e.1u(m.6S,e.1s(K(t,n){R r,i=J.1n.1q[n]={};J.23=n;R s=J.2j();r=s,i.2H=r.2H;R o=r.1D.1a,u={13:r.1D.1c.13,12:r.1D.1c.12};i.1D={1a:o,1c:u},i.1A={1a:r.1X.1a};18(J.1o){R a=J.1o.2j(),f=a.1X.1c,l=i.1D.1c;e.1i(!0,i,{2H:a.2H,1D:{1c:{13:l.13+f.13,12:l.12+f.12}},1A:{1a:a.1A.1a}})}},J)),J.23=t}K n(){J.35(),J.17.1o&&(E.1z(J.1e),J.17.1v&&J.17.1v.1o&&x.1z(J.1e)),J.2R&&(J.2R.1z(),J.2R=1p),J.1g&&(e(J.1g).1z(),J.1g=1p)}K r(){18(!J.1D)15;J.1v&&(e(J.1v).1z(),J.1v=1p,J.5X=1p,J.5Y=1p),e(J.1D).1z(),J.1h=1p,J.1j=1p,J.1D=1p,J.1n={}}K s(){R e=J.26();J.2E=e.1n.2E;R t=e.17;J.1k=t.1k&&t.1k.2p||0,J.1f=t.1f&&t.1f.2p||0,J.2g=t.2g;R n=19.4N(J.2E.14,J.2E.11);J.1k>n/2&&(J.1k=19.5Z(n/2)),J.17.1k.1c=="1f"&&J.1k>J.1f&&(J.1f=J.1k),J.1n={17:{1k:J.1k,1f:J.1f,2g:J.2g}}}K o(){J.35(),1I.4O&&1I.4O.8Q(1t);R t=J.26(),n=J.17;J.1D=e("<29>").1U("8R")[0],e(t.4S).1V(J.1D),J.4T(),J.72(t),n.1v&&(J.73(t),n.1v.1o&&(J.2S?(J.2S.17=n.1v.1o,J.2S.1L()):J.2S=2F T(J.1e,e.1i({2K:J.2s},n.1v.1o)))),i.3k&&i.3k<7&&e(t.1g).60(J.2R=e("<8S>").1U("8T").3d({8U:0,4f:"8V:\'\';"})),J.4U(),n.1o&&(J.1o?(J.1o.17=n.1o,J.1o.1L()):J.1o=2F S(J.1e,J,e.1i({2K:J.2s},n.1o))),J.74()}K u(){R t=J.26(),n=e(t.1g),r=e(t.1g).61(".75").76()[0];18(r){e(r).1l({11:"62",14:"62"});R i=2M(n.1l("13")),s=2M(n.1l("12")),o=2M(n.1l("11"));n.1l({12:"-77",13:"-77",11:"8W",14:"62"}),t.1E("1J")||e(t.1g).1S();R u=C.4V.63(r);t.17.3e&&e.1m(t.17.3e)=="2v"&&u.11>t.17.3e&&(e(r).1l({11:t.17.3e+"2r"}),u=C.4V.63(r)),t.1E("1J")||e(t.1g).1F(),t.1n.2E=u,n.1l({12:s+"2r",13:i+"2r",11:o+"2r"}),J.1L()}}K a(e,t,n){R r=!1;J.4g(e)&&(r=!0),J.78(t)&&(r=!0),n&&J.79(n)&&(r=!0),r&&J.1L()}K l(e){R t=!1;18(J.3i.12!=e.12||J.3i.13!=e.13)t=!0,J.3i=e;15 t}K c(e){R t=!1;18(J.38.x!=e.x||J.38.y!=e.y)t=!0,J.38=e;15 t}K p(e,t){R n=!1;15 J.23!=e&&(n=!0,J.23=e),n}K d(){15 C.1r(J.1e)[0]}K b(){15 g.3M(J,J.1f)}K w(){R t=J.26().17.1v,n=t.3s+t.1f*2;e(J.5X).1l({12:-1*n+"2r"}),e(J.5Y).1l({12:0})}K N(){R t=J.26().17.1v,n=t.3s+t.1f*2;e(J.5X).1l({12:0}),e(J.5Y).1l({12:n+"2r"})}K k(t){R n=t.17.1v,r={11:n.3s+2*n.1f,14:n.3s+2*n.1f};e(t.1g).1V(e(J.1v=1t.1Z("29")).1U("7a").1l(f(r)).1V(e(J.7b=1t.1Z("29")).1U("8X").1l(f(r)))),J.64(t,"65"),J.64(t,"66"),!1T.31.4I&&!i.4G&&e(J.1v).3N("4h",e.1s(J.7c,J)).3N("4W",e.1s(J.7d,J))}K L(t,n){R r=t.17.1v,i=r.3s,s=r.1f||0,o=r.x.3s,u=r.x.2p,a=r.x.8Y,l=r.2m[n||"65"],c={11:i+2*s,14:i+2*s};o>=i&&(o=i-2);R p;e(J.7b).1V(e(J[n+"7e"]=1t.1Z("29")).1U("8Z").1l(e.1i(f(c),{12:(n=="66"?c.11:0)+"2r"}))),e(1t.3a).1V(e(p=1t.1Z("3c"))),v.3C(p,c),v.3n(p);R d=p.3m("2d");d.2K=J.2s,e(J[n+"7e"]).1V(p),d.91(c.11/2,c.14/2),d.2O=v.41(d,l.1j,{3D:0,3E:0-i/2,3F:0,3G:0+i/2}),d.27(),d.22(0,0,i/2,0,19.2W*2,!0),d.28(),d.33(),s&&(d.2O=v.41(d,l.1f,{3D:0,3E:0-i/2-s,3F:0,3G:0+i/2+s}),d.27(),d.22(0,0,i/2,19.2W,0,!1),d.1b((i+s)/2,0),d.22(0,0,i/2+s,0,19.2W,!0),d.22(0,0,i/2+s,19.2W,0,!0),d.1b(i/2,0),d.22(0,0,i/2,0,19.2W,!1),d.28(),d.33());R m=o/2,g=u/2;18(g>m){R b=g;g=m,m=b}d.2O=y.2P(l.x.1M||l.x,l.x.1G||1),d.4X(h(45)),d.27(),d.3p(0,0),d.1b(0,m);2k(R w=0;w<4;w++)d.1b(0,m),d.1b(g,m),d.1b(g,m-(m-g)),d.1b(m,g),d.1b(m,0),d.4X(h(90));d.28(),d.33()}K A(t){R n=e.1i({1h:!1,3t:1p,92:1p,27:!1,28:!1,3u:1p,3v:1p,1k:0,1f:0,4Y:0,36:{x:0,y:0}},1Y[1]||{}),r=n.3u,i=n.3v,s=n.36,o=n.1f,u=n.1k,a=n.3t,f=r.1j.1c,l=r.1j.1a,c,p,d,v,y,b={x:19.2y(J.38.x),y:19.2y(J.38.y)},w={x:0,y:0},E={x:0,y:0};18(i){c=i.1h.1a,p=i.2x.1c,d=i.2x.1a,v=d.11-c.11;R S=n.4Y,x=o+u+.5*c.11-.5*i.1f.1a.11;y=19.1B(S>x?S-x:0);R T=g.5U(s,a,l,i.1f.1a,o,u);s=T.1w,E=T.4d,w={x:19.1Q(l.11-19.1Q(y,s.x||0)*2-i.1f.1a.11-(2*u||0),0),y:19.1Q(l.14-19.1Q(y,s.y||0)*2-i.1f.1a.14-(2*u||0),0)},m.34(a)&&(w.x*=.5,w.y*=.5),b.x=19.4N(b.x,w.x),b.y=19.4N(b.y,w.y),m.34(a)&&(J.38.x<0&&b.x>0&&(b.x*=-1),J.38.y<0&&b.y>0&&(b.y*=-1)),J.3i&&J.3i.3w&&e.1u(J.3i.3w,K(t,n){e.1u("13 1N 1O 12".30(" "),K(e,t){n==t&&(2F 5D("("+t+")$")).3O(a)&&(b[/^(12|1N)$/.3O(t)?"x":"y"]=0)})})}R N,C;u?(N=f.12+o+u,C=f.13+o):(N=f.12+o,C=f.13+o),s&&s.x&&/^(3H|3K)$/.3O(a)&&(N+=s.x),n.27&&t.27(),t.3p(N,C);18(n.1h)1P(a){1d"3H":N=f.12+o,u&&(N+=u),N+=19.1Q(y,s.x||0),N+=b.x,t.1b(N,C),C-=c.14,N+=c.11*.5,t.1b(N,C),C+=c.14,N+=c.11*.5,t.1b(N,C);1y;1d"42":1d"4Z":N=f.12+l.11*.5-c.11*.5,N+=b.x,t.1b(N,C),C-=c.14,N+=c.11*.5,t.1b(N,C),C+=c.14,N+=c.11*.5,t.1b(N,C),N=f.12+l.11*.5-d.11*.5,t.1b(N,C);1y;1d"3I":N=f.12+l.11-o-c.11,u&&(N-=u),N-=19.1Q(y,s.x||0),N-=b.x,t.1b(N,C),C-=c.14,N+=c.11*.5,t.1b(N,C),C+=c.14,N+=c.11*.5,t.1b(N,C)}u?u&&(t.22(f.12+l.11-o-u,f.13+o+u,u,h(-90),h(0),!1),N=f.12+l.11-o,C=f.13+o+u):(N=f.12+l.11-o,C=f.13+o,t.1b(N,C));18(n.1h)1P(a){1d"3J":C=f.13+o,u&&(C+=u),C+=19.1Q(y,s.y||0),C+=b.y,t.1b(N,C),N+=c.14,C+=c.11*.5,t.1b(N,C),N-=c.14,C+=c.11*.5,t.1b(N,C);1y;1d"43":1d"51":C=f.13+l.14*.5-c.11*.5,C+=b.y,t.1b(N,C),N+=c.14,C+=c.11*.5,t.1b(N,C),N-=c.14,C+=c.11*.5,t.1b(N,C);1y;1d"44":C=f.13+l.14-o,u&&(C-=u),C-=c.11,C-=19.1Q(y,s.y||0),C-=b.y,t.1b(N,C),N+=c.14,C+=c.11*.5,t.1b(N,C),N-=c.14,C+=c.11*.5,t.1b(N,C)}u?u&&(t.22(f.12+l.11-o-u,f.13+l.14-o-u,u,h(0),h(90),!1),N=f.12+l.11-o-u,C=f.13+l.14-o):(N=f.12+l.11-o,C=f.13+l.14-o,t.1b(N,C));18(n.1h)1P(a){1d"46":N=f.12+l.11-o,u&&(N-=u),N-=19.1Q(y,s.x||0),N-=b.x,t.1b(N,C),N-=c.11*.5,C+=c.14,t.1b(N,C),N-=c.11*.5,C-=c.14,t.1b(N,C);1y;1d"47":1d"52":N=f.12+l.11*.5+c.11*.5,N+=b.x,t.1b(N,C),N-=c.11*.5,C+=c.14,t.1b(N,C),N-=c.11*.5,C-=c.14,t.1b(N,C);1y;1d"48":N=f.12+o+c.11,u&&(N+=u),N+=19.1Q(y,s.x||0),N+=b.x,t.1b(N,C),N-=c.11*.5,C+=c.14,t.1b(N,C),N-=c.11*.5,C-=c.14,t.1b(N,C)}u?u&&(t.22(f.12+o+u,f.13+l.14-o-u,u,h(90),h(2C),!1),N=f.12+o,C=f.13+l.14-o-u):(N=f.12+o,C=f.13+l.14-o,t.1b(N,C));18(n.1h)1P(a){1d"49":C=f.13+l.14-o,u&&(C-=u),C-=19.1Q(y,s.y||0),C-=b.y,t.1b(N,C),N-=c.14,C-=c.11*.5,t.1b(N,C),N+=c.14,C-=c.11*.5,t.1b(N,C);1y;1d"4a":1d"53":C=f.13+l.14*.5+c.11*.5,C+=b.y,t.1b(N,C),N-=c.14,C-=c.11*.5,t.1b(N,C),N+=c.14,C-=c.11*.5,t.1b(N,C);1y;1d"3K":C=f.13+o+c.11,u&&(C+=u),C+=19.1Q(y,s.y||0),C+=b.y,t.1b(N,C),N-=c.14,C-=c.11*.5,t.1b(N,C),N+=c.14,C-=c.11*.5,t.1b(N,C)}15 u?u&&(t.22(f.12+o+u,f.13+o+u,u,h(-2C),h(-90),!1),N=f.12+o+u,C=f.13+o,N+=1,t.1b(N,C)):(N=f.12+o,C=f.13+o,t.1b(N,C)),n.28&&t.28(),{x:N,y:C,1h:b,7f:E,36:s}}K O(t){R n=e.1i({1h:!1,3t:1p,27:!1,28:!1,3u:1p,3v:1p,1k:0,1f:0,7g:0,36:{x:0,y:0},54:1p},1Y[1]||{}),r=n.3u,i=n.3v,s=n.7g,o=n.36,u=n.1f,a=n.1k&&n.1k.2p||0,f=n.7h,l=n.3t,c=r.1j.1c,p=r.1j.1a,d,v,m,g,y,b,w=n.54&&n.54.1h||{x:0,y:0};18(i){d=i.1h.1a,v=i.2x.1c,m=i.2x.1a,g=i.1f.1a,y=m.11-d.11;R E=u+f+.5*d.11-.5*g.11;b=19.1B(a>E?a-E:0)}R S=c.12+u+f,x=c.13+u;f&&(S+=1);R T=e.1i({},{x:S,y:x});n.27&&t.27();R N=e.1i({},{x:S,y:x});x-=u,t.1b(S,x),a?a&&(t.22(c.12+a,c.13+a,a,h(-90),h(-2C),!0),S=c.12,x=c.13+a):(S=c.12,x=c.13,t.1b(S,x));18(n.1h)1P(l){1d"3K":x=c.13+u,f&&(x+=f),x-=g.11*.5,x+=d.11*.5,x+=19.1Q(b,o.y||0),x+=w.y,t.1b(S,x),S-=g.14,x+=g.11*.5,t.1b(S,x),S+=g.14,x+=g.11*.5,t.1b(S,x);1y;1d"4a":1d"53":x=c.13+p.14*.5-g.11*.5,x+=w.y,t.1b(S,x),S-=g.14,x+=g.11*.5,t.1b(S,x),S+=g.14,x+=g.11*.5,t.1b(S,x);1y;1d"49":x=c.13+p.14-u-g.11,f&&(x-=f),x+=g.11*.5,x-=d.11*.5,x-=19.1Q(b,o.y||0),x-=w.y,t.1b(S,x),S-=g.14,x+=g.11*.5,t.1b(S,x),S+=g.14,x+=g.11*.5,t.1b(S,x)}a?a&&(t.22(c.12+a,c.13+p.14-a,a,h(-2C),h(-93),!0),S=c.12+a,x=c.13+p.14):(S=c.12,x=c.13+p.14,t.1b(S,x));18(n.1h)1P(l){1d"48":S=c.12+u,f&&(S+=f),S-=g.11*.5,S+=d.11*.5,S+=19.1Q(b,o.x||0),S+=w.x,t.1b(S,x),x+=g.14,S+=g.11*.5,t.1b(S,x),x-=g.14,S+=g.11*.5,t.1b(S,x);1y;1d"47":1d"52":S=c.12+p.11*.5-g.11*.5,S+=w.x,t.1b(S,x),x+=g.14,S+=g.11*.5,t.1b(S,x),x-=g.14,S+=g.11*.5,t.1b(S,x),S=c.12+p.11*.5+g.11,t.1b(S,x);1y;1d"46":S=c.12+p.11-u-g.11,f&&(S-=f),S+=g.11*.5,S-=d.11*.5,S-=19.1Q(b,o.x||0),S-=w.x,t.1b(S,x),x+=g.14,S+=g.11*.5,t.1b(S,x),x-=g.14,S+=g.11*.5,t.1b(S,x)}a?a&&(t.22(c.12+p.11-a,c.13+p.14-a,a,h(90),h(0),!0),S=c.12+p.11,x=c.13+p.11+a):(S=c.12+p.11,x=c.13+p.14,t.1b(S,x));18(n.1h)1P(l){1d"44":x=c.13+p.14-u,x+=g.11*.5,x-=d.11*.5,f&&(x-=f),x-=19.1Q(b,o.y||0),x-=w.y,t.1b(S,x),S+=g.14,x-=g.11*.5,t.1b(S,x),S-=g.14,x-=g.11*.5,t.1b(S,x);1y;1d"43":1d"51":x=c.13+p.14*.5+g.11*.5,x+=w.y,t.1b(S,x),S+=g.14,x-=g.11*.5,t.1b(S,x),S-=g.14,x-=g.11*.5,t.1b(S,x);1y;1d"3J":x=c.13+u,f&&(x+=f),x+=g.11,x-=g.11*.5-d.11*.5,x+=19.1Q(b,o.y||0),x+=w.y,t.1b(S,x),S+=g.14,x-=g.11*.5,t.1b(S,x),S-=g.14,x-=g.11*.5,t.1b(S,x)}a?a&&(t.22(c.12+p.11-a,c.13+a,a,h(0),h(-90),!0),S=c.12+p.11-a,x=c.13):(S=c.12+p.11,x=c.13,t.1b(S,x));18(n.1h)1P(l){1d"3I":S=c.12+p.11-u,S+=g.11*.5-d.11*.5,f&&(S-=f),S-=19.1Q(b,o.x||0),S-=w.x,t.1b(S,x),x-=g.14,S-=g.11*.5,t.1b(S,x),x+=g.14,S-=g.11*.5,t.1b(S,x);1y;1d"42":1d"4Z":S=c.12+p.11*.5+g.11*.5,S+=w.x,t.1b(S,x),x-=g.14,S-=g.11*.5,t.1b(S,x),x+=g.14,S-=g.11*.5,t.1b(S,x),S=c.12+p.11*.5-g.11,t.1b(S,x),t.1b(S,x);1y;1d"3H":S=c.12+u+g.11,S-=g.11*.5,S+=d.11*.5,f&&(S+=f),S+=19.1Q(b,o.x||0),S+=w.x,t.1b(S,x),x-=g.14,S-=g.11*.5,t.1b(S,x),x+=g.14,S-=g.11*.5,t.1b(S,x)}t.1b(N.x,N.y-u),t.1b(N.x,N.y),n.28&&t.28()}K M(t){R n=J.2j(),r=J.17.1h&&J.4i(),i=J.23&&J.23.3r(),s=J.1k,o=s*2,u=J.1f,a=J.2g,f={11:u*2+a*2+J.2E.11,14:u*2+a*2+J.2E.14},l=t.17.1h&&t.17.1h.1w||{x:0,y:0},c=0,h=0;s&&(c=J.17.1k.1c=="1j"?s:0,h=J.17.1k.1c=="1f"?s:c+u),e(1t.3a).1V(J.2T=1t.1Z("3c")),v.3C(J.2T,n.1D.1a),v.3n(J.2T);R p=J.2T.3m("2d");p.2K=J.2s,e(J.1D).1V(J.2T),p.2O=v.41(p,J.17.1j,{3D:0,3E:n.1j.1c.13+u,3F:0,3G:n.1j.1c.13+n.1j.1a.14-u}),p.94=0;R d;d=J.67(p,{27:!0,28:!0,1f:u,1k:c,4Y:h,3u:n,3v:r,1h:J.17.1h,3t:i,36:l}),p.33();18(u){R m=v.41(p,J.17.1f,{3D:0,3E:n.1j.1c.13,3F:0,3G:n.1j.1c.13+n.1j.1a.14});p.2O=m,d=J.67(p,{27:!0,28:!1,1f:u,1k:c,4Y:h,3u:n,3v:r,1h:J.17.1h,3t:i,36:l}),J.7i(p,{27:!1,28:!0,1f:u,7h:c,1k:{2p:h,1c:J.17.1k.1c},3u:n,3v:r,1h:J.17.1h,3t:i,36:d.36,54:d}),p.33()}J.4j=d}K 2a(){R e=J.26(),t=J.2E,n=e.17,r=J.1k,i=r*2,s=J.1f,o=J.2g,u={11:s*2+o*2+t.11,14:s*2+o*2+t.14},a;18(J.17.1h){R f=J.4i();a=f.2x.1a}R l=g.5T(J,u),c=l.1a,p=l.1c,u=l.1j.1a,d=l.1j.1c,v=l.1h.1a,m={13:0,12:0},y,b,w,E={11:c.11,14:c.14};18(n.1v){R S=r;n.1k.1c=="1j"&&(S+=s);R x=S-19.95(h(45))*S,T="1N";J.23.3r().3b(/^(3I|3J)$/)&&(T="12");R N=n.1v.3s+2*n.1v.1f,y={11:N,14:N};m.12=d.12-N/2+(T=="12"?x:u.11-x),m.13=d.13-N/2+x;18(T=="12"){18(m.12<0){R C=19.2y(m.12);E.11+=C,p.12+=C,m.12=0}}1C{R k=m.12+N-E.11;k>0&&(E.11+=k)}18(m.13<0){R L=19.2y(m.13);E.14+=L,p.13+=L,m.13=0}18(J.17.1v.1o){R A=J.17.1v.1o,O=A.2Y,M=A.1w;b={11:y.11+2*O,14:y.14+2*O},w={13:m.13-O+M.y,12:m.12-O+M.x};18(T=="12"){18(w.12<0){R C=19.2y(w.12);E.11+=C,p.12+=C,m.12+=C,w.12=0}}1C{R k=w.12+b.11-E.11;k>0&&(E.11+=k)}18(w.13<0){R L=19.2y(w.13);E.14+=L,p.13+=L,m.13+=L,w.13=0}}}R 2a=l.2H;2a.13+=p.13,2a.12+=p.12;R D={12:19.1B(p.12+d.12+J.1f+J.17.2g),13:19.1B(p.13+d.13+J.1f+J.17.2g)},P={1A:{1a:{11:19.1B(E.11),14:19.1B(E.14)}},1X:{1a:{11:19.1B(E.11),14:19.1B(E.14)}},1D:{1a:c,1c:{13:19.20(p.13),12:19.20(p.12)}},1j:{1a:{11:19.1B(u.11),14:19.1B(u.14)},1c:{13:19.20(d.13),12:19.20(d.12)}},2H:{13:19.20(2a.13),12:19.20(2a.12)},2D:{1c:D}};15 J.17.1v&&(P.1v={1a:{11:19.1B(y.11),14:19.1B(y.14)},1c:{13:19.20(m.13),12:19.20(m.12)}},J.17.1v.1o&&(P.2S={1a:{11:19.1B(b.11),14:19.1B(b.14)},1c:{13:19.20(w.13),12:19.20(w.12)}})),P}K D(){R t=J.2j(),n=J.26();e(n.1g).1l(f(t.1A.1a)),e(n.4S).1l(f(t.1X.1a)),J.2R&&J.2R.1l(f(t.1A.1a)),e(J.1D).1l(e.1i(f(t.1D.1a),f(t.1D.1c))),J.1v&&(e(J.1v).1l(f(t.1v.1c)),t.2S&&e(J.2S.1g).1l(f(t.2S.1c))),e(n.3f).1l(f(t.2D.1c))}K P(e){J.2s=e||0,J.1o&&(J.1o.2s=J.2s)}K H(e){J.7j(e),J.1L()}15{4T:s,74:t,1L:o,1z:n,35:r,26:d,2N:u,56:a,79:l,78:c,4g:p,73:k,64:L,72:M,67:A,7i:O,7c:w,7d:N,4i:b,2j:2a,4U:D,7j:P,96:H}}());R E={3g:{},1r:K(t){18(!t)15 1p;R n=1p,r=e(t).1W("2l-1R");15 r&&(n=J.3g[r]),n},2X:K(e){J.3g[e.1R]=e},1z:K(e){R t=J.1r(e);t&&(4e J.3g[t.1R],t.1z())},4k:K(e){15 19.2W/2-19.4H(e,19.4t(e)*19.2W)}};E.4l={4c:K(e,t){R n=b.1r(e.1e),r=n.4i().1f.1a,i=J.4P(r.11,r.14,t,{3L:!1});15{11:i.11,14:i.14}},97:K(e,t,n){R r=e*.5,i=c(19.98(r/l(r,t))),s=2C-i-90,o=p(h(s))*n,u=(r+o)*2,a=u/e*t;15{11:u,14:a}},4P:K(e,t,n){R r=c(19.6X(t/e*.5)),i=2C-r,s=19.4t(h(i-90))*n,o=e+s*2,u=o*t/e;15{11:o,14:u}},3M:K(t){R n=b.1r(t.1e),r=t.17.2Y,i=m.6W(n.23),s=m.2G(n.23),o=E.4l.4c(t,r),u={2x:{1a:{11:19.1B(o.11),14:19.1B(o.14)},1c:{13:0,12:0}}};18(r){u.2U=[];2k(R a=0;a<=r;a++){R f=E.4l.4c(t,a,{3L:!1}),l={1c:{13:u.2x.1a.14-f.14,12:i?r-a:(u.2x.1a.11-f.11)/2},1a:f};u.2U.2n(l)}}1C u.2U=[e.1i({},u.2x)];15 u},4X:K(e,t,n){g.4X(e,t.3h(),n)}},e.1i(S.3A,K(){K t(){15 C.1r(J.1e)[0]}K n(){15 b.1r(J.1e)}K r(){J.35()}K i(){18(!J.1g)15;e(J.1g).1z(),J.1h=1p,J.1j=1p,J.1D=1p,J.1g=1p,J.1n={}}K s(){}K o(){J.35(),J.4T();R t=J.26(),n=J.3h();J.1g=e("<29>").1U("99")[0],e(t.1g).60(J.1g),n.2R&&e(t.1g).60(n.2R);R r=n.2j();e(J.1g).1l({13:0,12:0}),J.7k(),J.4U()}K u(){15 J.17.1G/(J.17.2Y+1)}K a(){R t=J.3h(),n=t.2j(),r=J.26(),i=J.2j(),s=J.17.2Y,o=E.4l.3M(J),u=t.23,a=m.5R(u),l={13:s,12:s};18(r.17.1h){R c=o.2U[o.2U.2f-1];a=="12"&&(l.12+=19.1B(c.1a.14)),a=="13"&&(l.13+=19.1B(c.1a.14))}R h=t.1n.17,p=h.1k,d=h.1f;r.17.1k.1c=="1j"&&p&&(p+=d);R g=i.1D.1a;e(J.1g).1V(e(J.1D=1t.1Z("29")).1U("9a").1l(f(g))).1l(f(g)),e(1t.3a).1V(e(J.2T=1t.1Z("3c"))),v.3C(J.2T,i.1D.1a),v.3n(J.2T);R b=J.2T.3m("2d");b.2K=J.2s,e(J.1D).1V(J.2T);R w=s+1;2k(R S=0;S<=s;S++)b.2O=y.2P(J.17.1M,E.4k(S*(1/w))*(J.17.1G/w)),v.6N(b,{11:n.1j.1a.11+S*2,14:n.1j.1a.14+S*2,13:l.13-S,12:l.12-S,1k:p+S});18(!t.17.1h)15;R x={x:l.12,y:l.13},T=o.2U[0].1a,N=t.17.1h,C=d;C+=N.11*.5;R k=t.17.1k&&t.17.1k.1c=="1j"?t.17.1k.2p||0:0;k&&(C+=k);R L=d+k+.5*N.11-.5*T.11,A=19.1B(p>L?p-L:0),O=t.4j&&t.4j.1h||{x:0,y:0},M=t.4j&&t.4j.7f||{x:0,y:0};C+=19.1Q(A,t.17.1h.1w&&t.17.1h.1w[a&&/^(12|1N)$/.3O(a)?"y":"x"]||0);18(a=="13"||a=="1O"){1P(u){1d"3H":1d"48":x.x+=C+O.x-M.x;1y;1d"42":1d"4Z":1d"47":1d"52":x.x+=n.1j.1a.11*.5+O.x;1y;1d"3I":1d"46":x.x+=n.1j.1a.11-C-O.x+M.x}a=="1O"&&(x.y+=n.1j.1a.14);2k(R S=0,2a=o.2U.2f;S<2a;S++){b.2O=y.2P(J.17.1M,E.4k(S*(1/w))*(J.17.1G/w));R s=o.2U[S];b.27(),a=="13"?(b.3p(x.x,x.y-S),b.1b(x.x-s.1a.11*.5,x.y-S),b.1b(x.x,x.y-S-s.1a.14),b.1b(x.x+s.1a.11*.5,x.y-S)):(b.3p(x.x,x.y+S),b.1b(x.x-s.1a.11*.5,x.y+S),b.1b(x.x,x.y+S+s.1a.14),b.1b(x.x+s.1a.11*.5,x.y+S)),b.28(),b.33()}}1C{1P(u){1d"3K":1d"3J":x.y+=C+O.y-M.y;1y;1d"4a":1d"53":1d"43":1d"51":x.y+=n.1j.1a.14*.5+O.y;1y;1d"49":1d"44":x.y+=n.1j.1a.14-C-O.y+M.y}a=="1N"&&(x.x+=n.1j.1a.11);2k(R S=0,2a=o.2U.2f;S<2a;S++){b.2O=y.2P(J.17.1M,E.4k(S*(1/w))*(J.17.1G/w));R s=o.2U[S];b.27(),a=="12"?(b.3p(x.x-S,x.y),b.1b(x.x-S,x.y-s.1a.11*.5),b.1b(x.x-S-s.1a.14,x.y),b.1b(x.x-S,x.y+s.1a.11*.5)):(b.3p(x.x+S,x.y),b.1b(x.x+S,x.y-s.1a.11*.5),b.1b(x.x+S+s.1a.14,x.y),b.1b(x.x+S,x.y+s.1a.11*.5)),b.28(),b.33()}}}K l(){R t=J.3h(),n=t.2E,r=t.1k,i=t.2j(),s=J.26(),o=J.17.2Y,u=e.1i({},i.1j.1a);u.11+=2*o,u.14+=2*o;R a,f,l;18(t.17.1h){R c=E.4l.3M(J);a=c.2x.1a,l=a.14}R h=g.5T(t,u,l),p=h.1a,d=h.1c,u=h.1j.1a,v=h.1j.1c,m=a,y=i.1D.1c,b=i.1j.1c,w={13:y.13+b.13-(v.13+o)+J.17.1w.y,12:y.12+b.12-(v.12+o)+J.17.1w.x},S=i.2H,x=i.1X.1a,T={13:0,12:0};18(w.13<0){R N=19.2y(w.13);T.13+=N,w.13=0,S.13+=N}18(w.12<0){R C=19.2y(w.12);T.12+=C,w.12=0,S.12+=C}R k={14:19.1Q(p.14+w.13,x.14+T.13),11:19.1Q(p.11+w.12,x.11+T.12)},L={12:19.1B(T.12+i.1D.1c.12+i.1j.1c.12+t.1f+t.2g),13:19.1B(T.13+i.1D.1c.13+i.1j.1c.13+t.1f+t.2g)},A={1A:{1a:k},1X:{1a:x,1c:T},1g:{1a:p,1c:w},1D:{1a:p,1c:{13:19.20(d.13),12:19.20(d.12)}},1j:{1a:{11:19.1B(u.11),14:19.1B(u.14)},1c:{13:19.20(v.13),12:19.20(v.12)}},2H:S,2D:{1c:L}};15 A}K c(){R t=J.2j(),n=J.3h(),r=J.26();e(r.1g).1l(f(t.1A.1a)),e(r.4S).1l(e.1i(f(t.1X.1c),f(t.1X.1a))),n.2R&&n.2R.1l(f(t.1A.1a));18(r.17.1v){R i=n.2j(),s=t.1X.1c,o=i.1v.1c;e(n.1v).1l(f({13:s.13+o.13,12:s.12+o.12}));18(r.17.1v.1o){R u=i.2S.1c;e(n.2S.1g).1l(f({13:s.13+u.13,12:s.12+u.12}))}}e(J.1g).1l(e.1i(f(t.1g.1a),f(t.1g.1c))),e(J.1D).1l(f(t.1D.1a)),e(r.3f).1l(f(t.2D.1c))}15{4T:s,1z:r,35:i,1L:o,26:t,3h:n,2j:l,7l:u,7k:a,4U:c}}());R x={3g:{},1r:K(t){18(!t)15 1p;R n=e(t).1W("2l-1R");15 n?J.3g[n]:1p},2X:K(e){J.3g[e.1R]=e},1z:K(e){R t=J.1r(e);t&&(4e J.3g[t.1R],t.1z())}};e.1i(T.3A,K(){K t(){15 C.1r(J.1e)[0]}K n(){15 b.1r(J.1e)}K r(){15 J.17.1G/(J.17.2Y+1)}K i(){J.35()}K s(){18(!J.1g)15;e(J.1g).1z(),J.1g=1p}K o(){J.35();R t=J.26(),n=J.3h(),r=n.2j().1v.1a,i=e.1i({},r),s=J.17.2Y;i.11+=s*2,i.14+=s*2,e(n.1v).68(e(J.1g=1t.1Z("29")).1U("9b")),e(1t.3a).1V(e(J.4m=1t.1Z("3c"))),v.3C(J.4m,i),v.3n(J.4m);R o=J.4m.3m("2d");o.2K=J.2s,e(J.1g).1V(J.4m);R u=i.11/2,a=i.14/2,f=r.14/2,l=s+1;2k(R c=0;c<=s;c++)o.2O=y.2P(J.17.1M,E.4k(c*(1/l))*(J.17.1G/l)),o.27(),o.22(u,a,f+c,h(0),h(71),!0),o.28(),o.33()}15{1L:o,1z:i,35:s,26:t,3h:n,7l:r}}());R C={2I:{},17:{3P:"69",4v:9c},6L:K(){K t(){R t=["2z"];1T.31.4I&&(t.2n("9d"),e(1t.3a).3N("2z",K(){15 9e 0})),e.1u(t,K(t,n){e(1t.7m).9f(".3x .7a, .3x .9g-1A",n,K(t){t.9h(),t.9i(),C.6a(e(t.1x).57(".3x")[0]).1F()})}),e(1I).3N("3C",e.1s(J.7n,J))}15 t}(),7n:K(){J.58&&(1I.6b(J.58),J.58=1p),J.58=r.4z(e.1s(K(){R t=J.3B();e.1u(t,K(e,t){t.1c()})},J),9j)},59:K(t){R n=e(t).1W("2l-1R"),r;18(!n){R i=J.6a(e(t).57(".3x")[0]);i&&i.1e&&(n=e(i.1e).1W("2l-1R"))}18(n&&(r=J.2I[n]))15 r},5K:K(e){R t;15 r.2h(e)&&(t=J.59(e)),t&&t.1e},1r:K(t){R n=[];18(r.2h(t)){R i=J.59(t);i&&(n=[i])}1C e.1u(J.2I,K(r,i){i.1e&&e(i.1e).7o(t)&&n.2n(i)});15 n},6a:K(t){18(!t)15 1p;R n=1p;15 e.1u(J.2I,K(e,r){r.1E("1L")&&r.1g===t&&(n=r)}),n},9k:K(t){R n=[];15 e.1u(J.2I,K(r,i){i.1e&&e(i.1e).7o(t)&&n.2n(i)}),n},1S:K(t){18(r.2h(t)){R n=t,i=J.1r(n)[0];i&&i.1S()}1C e(t).1u(e.1s(K(e,t){R n=J.1r(t)[0];n&&n.1S()},J))},1F:K(t){18(r.2h(t)){R n=J.1r(t)[0];n&&n.1F()}1C e(t).1u(e.1s(K(e,t){R n=J.1r(t)[0];n&&n.1F()},J))},32:K(t){18(r.2h(t)){R n=t,i=J.1r(n)[0];i&&i.32()}1C e(t).1u(e.1s(K(e,t){R n=J.1r(t)[0];n&&n.32()},J))},4K:K(){e.1u(J.3B(),K(e,t){t.1F()})},2N:K(t){18(r.2h(t)){R n=t,i=J.1r(n)[0];i&&i.2N()}1C e(t).1u(e.1s(K(e,t){R n=J.1r(t)[0];n&&n.2N()},J))},3B:K(){R t=[];15 e.1u(J.2I,K(e,n){n.1J()&&t.2n(n)}),t},5N:K(t){R n=!1;15 r.2h(t)&&e.1u(J.3B()||[],K(e,r){18(r.1e==t)15 n=!0,!1}),n},7p:K(){R t=0,n;15 e.1u(J.2I,K(e,r){r.2e>t&&(t=r.2e,n=r)}),n},7q:K(){J.3B().2f<=1&&e.1u(J.2I,K(t,n){n.1E("1L")&&!n.17.2e&&e(n.1g).1l({2e:n.2e=+C.17.4v})})},2X:K(e){J.2I[e.1R]=e},5a:K(t){R n=J.59(t);18(n){R r=e(n.1e).1W("2l-1R");4e J.2I[r],n.1F(),n.1z()}},1z:K(t){r.2h(t)?J.5a(t):e(t).1u(e.1s(K(e,t){J.5a(t)},J))},6M:K(){e.1u(J.2I,e.1s(K(e,t){t.1e&&!r.1e.5C(t.1e)&&J.5a(t.1e)},J))},5L:K(e){J.17.3P=e||"69"},5M:K(e){J.17.4v=e||0},6t:K(){K s(r){R i;15 e.1m(r)=="2o"?i={1e:n.21&&n.21.1e||t.21.1e,2q:r}:i=N(e.1i({},t.21),r),i}K o(s){15 t=1T.2A.7r,n=N(e.1i({},t),1T.2A.6c),r=1T.2A.6d.7r,i=N(e.1i({},r),1T.2A.6d.6c),o=u,u(s)}K u(o){o.1X=o.1X&&1T.2A[o.1X]?o.1X:1T.2A[C.17.3P]?C.17.3P:"69";R u=o.1X?e.1i({},1T.2A[o.1X]||1T.2A[C.17.3P]):{},a=N(e.1i({},n),u),f=N(e.1i({},a),o);18(f.2b){R l=n.2b||{},c=t.2b;e.1m(f.2b)=="4n"&&(f.2b={4o:l.4o||c.4o,1m:l.1m||c.1m}),f.2b=N(e.1i({},c),f.2b)}f.1j&&e.1m(f.1j)=="2o"&&(f.1j={1M:f.1j,1G:1});18(f.1f){R h,p=n.1f||{},d=t.1f;e.1m(f.1f)=="2v"?h={2p:f.1f,1M:p.1M||d.1M,1G:p.1G||d.1G}:h=N(e.1i({},d),f.1f),f.1f=h.2p===0?!1:h}18(f.1k){R v;e.1m(f.1k)=="2v"?v={2p:f.1k,1c:n.1k&&n.1k.1c||t.1k.1c}:v=N(e.1i({},t.1k),f.1k),f.1k=v.2p===0?!1:v}R g,y=y=f.1q&&f.1q.1x||e.1m(f.1q)=="2o"&&f.1q||n.1q&&n.1q.1x||e.1m(n.1q)=="2o"&&n.1q||t.1q&&t.1q.1x||t.1q,b=f.1q&&f.1q.1A||n.1q&&n.1q.1A||t.1q&&t.1q.1A||C.2u.7s(y);f.1q?e.1m(f.1q)=="2o"?g={1x:f.1q,1A:C.2u.7t(f.1q)}:(g={1A:b,1x:y},f.1q.1A&&(g.1A=f.1q.1A),f.1q.1x&&(g.1x=f.1q.1x)):g={1A:b,1x:y};18(f.1x=="2L"){R w=m.2G(g.1x);w=="1K"?g.1x=g.1x.5V(/(12|1N)/,"2w"):g.1x=g.1x.5V(/(13|1O)/,"2w")}f.1q=g;R E;f.1x=="2L"?(E=e.1i({},t.1w),e.1i(E,1T.2A.6c.1w||{}),o.1X&&e.1i(E,(1T.2A[o.1X]||1T.2A[C.17.3P]).1w||{}),E=C.2u.7u(t.1w,t.1q,g.1x,!0),o.1w&&(E=e.1i(E,o.1w||{})),f.3Q=0):E={x:f.1w.x,y:f.1w.y},f.1w=E;18(f.1v&&f.7v){R S=e.1i({},1T.2A.6d[f.7v]),x=N(e.1i({},i),S);18(x.2m){R T={};e.1u(["65","66"],K(t,n){R s=x.2m[n],o=i.2m&&i.2m[n];18(s.1j){R u=o&&o.1j;18(e.1m(s.1j)=="2v")s.1j={1M:u&&u.1M||r.2m[n].1j.1M,1G:s.1j};1C 18(e.1m(s.1j)=="2o"){R a=u&&e.1m(u.1G)=="2v"&&u.1G||r.2m[n].1j.1G;s.1j={1M:s.1j,1G:a}}1C s.1j=N(e.1i({},r.2m[n].1j),s.1j)}18(s.1f){R f=o&&o.1f;e.1m(s.1f)=="2v"?s.1f={1M:f&&f.1M||r.2m[n].1f.1M,1G:s.1f}:s.1f=N(e.1i({},r.2m[n].1f),s.1f)}})}18(x.1o){R k=i.1o&&i.1o.3y&&i.1o.3y==5r?i.1o:r.1o;x.1o.3y&&x.1o.3y==5r&&(k=N(k,x.1o)),x.1o=k}f.1v=x}18(f.1o){R L;e.1m(f.1o)=="4n"?n.1o&&e.1m(n.1o)=="4n"?L=t.1o:n.1o?L=n.1o:L=t.1o:L=N(e.1i({},t.1o),f.1o||{}),e.1m(L.1w)=="2v"&&(L.1w={x:L.1w,y:L.1w}),f.1o=L}18(f.1h){R A={};e.1m(f.1h)=="4n"?A=N({},t.1h):A=N(N({},t.1h),e.1i({},f.1h)),e.1m(A.1w)=="2v"&&(A.1w={x:A.1w,y:A.1w}),f.1h=A}f.2V&&(e.1m(f.2V)=="2o"?f.2V={5b:f.2V,7w:!0}:e.1m(f.2V)=="4n"&&(f.2V=f.2V?{5b:"4M",7w:!0}:!1)),f.21&&f.21=="2z-9l"&&(f.7x=!0,f.21=!1);18(f.21)18(e.6P(f.21)){R O=[];e.1u(f.21,K(e,t){O.2n(s(t))}),f.21=O}1C f.21=[s(f.21)];15 f.2J&&e.1m(f.2J)=="2o"&&(f.2J=[""+f.2J]),f.2g=0,f.1H&&(1I.6e||(f.1H=!1)),f}R t,n,r,i;15 o}()};C.2u=K(){K n(n){R r=m.30(n),i=r[1],s=r[2],o=m.2G(n),u=e.1i({1K:!0,2i:!0},1Y[1]||{});15 o=="1K"?(u.2i&&(i=t[i]),u.1K&&(s=t[s])):(u.2i&&(s=t[s]),u.1K&&(i=t[i])),i+s}K s(e){R r=m.30(e);15 n(r[1]+t[r[2]])}K o(e,t,n,r){15 19.6r(19.4H(19.2y(n-e),2)+19.4H(19.2y(r-t),2))}K u(t,n){e(t.1g).1l({13:n.13+"2r",12:n.12+"2r"})}K f(e,t,r,i){R s=T(e,t,r,i),o=r&&7y r.1m=="2o"?r.1m:"",u=/9m$/.3O(o),a=[];18(s.3R.3S===1)15 c(e,s),s;R f=t,h=i,p={1K:!s.3R.1K,2i:!s.3R.2i},d={1K:!1,2i:!1};18((d.2i=m.2G(t)=="1K"&&p.2i)||(d.1K=m.2G(t)=="2i"&&p.1K)){f=n(t,d),h=n(i,d),s=T(e,f,r,h);18(s.3R.3S===1)15 c(e,s),s}15 s=l(s,e),c(e,s),s}K l(e,t){R n=N(t),r=n.1a,i=n.1c,s=b.1r(t.1e).1n.1q[e.1q.1A].1A.1a,o=e.1c,u={13:0,12:0,3w:[]};15 i.12>o.12&&(u.12=i.12-o.12,u.3w.2n("12"),e.1c.12=i.12),i.13>o.13&&(u.13=o.13-i.13,u.3w.2n("13"),e.1c.13=i.13),i.12+r.11<o.12+s.11&&(u.12=i.12+r.11-(o.12+s.11),u.3w.2n("1N"),e.1c.12=i.12+r.11-s.11),i.13+r.14<o.13+s.14&&(u.13=i.13+r.14-(o.13+s.14),u.3w.2n("1O"),e.1c.13=i.13+r.14-s.14),e.7z=u,e}K c(e,t){e.56(t.1q.1A,t.3R.4d,t.7z),u(e,t.1c)}K h(e){15 e&&(/^2L|2z|4I$/.3O(7y e.1m=="2o"&&e.1m||"")||e.5A>=0)}K p(e,t,n){15 e>=t&&e<=n}K v(e,t,n,r){R i=p(e,n,r),s=p(t,n,r);18(i&&s)15 t-e;18(i&&!s)15 r-e;18(!i&&s)15 t-n;R o=p(n,e,t),u=p(r,e,t);15 o&&u?r-n:o&&!u?t-n:!o&&u?r-e:0}K g(e,t){15 v(e.1c.12,e.1c.12+e.1a.11,t.1c.12,t.1c.12+t.1a.11)*v(e.1c.13,e.1c.13+e.1a.14,t.1c.13,t.1c.13+t.1a.14)}K y(e,t){R n=e.1a.11*e.1a.14;15 n?g(e,t)/n:0}K w(e,t){R n=m.30(t),r=m.2G(t),i={12:0,13:0};18(r=="1K"){1P(n[2]){1d"2w":1d"2Q":i.12=.5*e.11;1y;1d"1N":i.12=e.11}n[1]=="1O"&&(i.13=e.14)}1C{1P(n[2]){1d"2w":1d"2Q":i.13=.5*e.14;1y;1d"1O":i.13=e.14}n[1]=="1N"&&(i.12=e.11)}15 i}K S(t){R n=r.1e.4E(t),i=r.1e.4A(t),s={13:e(1I).4B(),12:e(1I).4C()};15 n.12+=-1*(i.12-s.12),n.13+=-1*(i.13-s.13),n}K T(t,i,s,o){R u,a,f,l=b.1r(t.1e),c=l.17,p=c.1w,d=h(s);18(d||!s){f={11:24,14:24};18(d){R v=r.5z(s);u={13:v.y-.5*f.14+6,12:v.x-.5*f.11+6}}1C{R g=t.1n.2q;u={13:(g?g.y:0)-.5*f.14+6,12:(g?g.x:0)-.5*f.11+6}}t.1n.2q={x:u.12,y:u.13}}1C u=S(s),f={11:e(s).7A(),14:e(s).7B()};18(c.1h&&c.1x!="2L"){R T=m.30(o),C=m.30(i),k=m.2G(o),L=l.1n.17,A=l.4i().1f.1a,O=L.1k,M=L.1f,2a=O&&c.1k.1c=="1j"?O:0,P=O&&c.1k.1c=="1f"?O:O+M,H=M+2a+.5*c.1h.11-.5*A.11,j=P>H?P-H:0;4p=19.1B(M+2a+.5*c.1h.11+j+c.1h.1w[k=="1K"?"x":"y"]);18(k=="1K"&&T[2]=="12"&&C[2]=="12"||T[2]=="1N"&&C[2]=="1N")f.11-=4p*2,u.12+=4p;1C 18(k=="2i"&&T[2]=="13"&&C[2]=="13"||T[2]=="1O"&&C[2]=="1O")f.14-=4p*2,u.13+=4p}a=e.1i({},u);R F=d?n(c.1q.1A):c.1q.1x,q=w(f,F),U=w(f,o),W={13:u.13+q.13+p.y,12:u.12+q.12+p.x};u={12:u.12+U.12,13:u.13+U.13};R X=e.1i({},p);X=x(X,F,o,l.17.1x=="2L"),u.13+=X.y,u.12+=X.x;R l=b.1r(t.1e),V=l.1n.1q,$=e.1i({},V[i]),Q={13:u.13-$.2H.13,12:u.12-$.2H.12};$.1A.1c=Q;R G={1K:!0,2i:!0},Y={x:0,y:0};18(t.17.2V){R Z=N(t),7C=t.17.1o?E.1r(t.1e):l,3T=7C.2j().1A.1a;G.3S=y({1a:3T,1c:Q},Z);18(G.3S<1){18(Q.12<Z.1c.12||Q.12+3T.11>Z.1c.12+Z.1a.11)G.1K=!1,Q.12<Z.1c.12?Y.x=Q.12-Z.1c.12:Y.x=Q.12+3T.11-(Z.1c.12+Z.1a.11);18(Q.13<Z.1c.13||Q.13+3T.14>Z.1c.13+Z.1a.14)G.2i=!1,Q.13<Z.1c.13?Y.y=Q.13-Z.1c.13:Y.y=Q.13+3T.14-(Z.1c.13+Z.1a.14)}}1C G.3S=1;G.4d=Y;R z=V[i].1D,7D=y({1a:f,1c:a},{1a:z.1a,1c:{13:Q.13+z.1c.13,12:Q.12+z.1c.12}});15{1c:Q,3S:{1x:7D},3R:G,1q:{1A:i,1x:o}}}K N(t){R n={13:e(1I).4B(),12:e(1I).4C()},i=t.17,s=i.1x;18(s=="2L"||s=="4y")s=t.1e;R o=e(s).57(i.2V.5b).76()[0];18(!o||i.2V.5b=="4M")15{1a:d.4M(),1c:n};R u=r.1e.4E(o),a=r.1e.4A(o);15 u.12+=-1*(a.12-n.12),u.13+=-1*(a.13-n.13),{1a:{11:e(o).5P(),14:e(o).5Q()},1c:u}}R t={12:"1N",1N:"12",13:"1O",1O:"13",2w:"2w",2Q:"2Q"},a=i.3k&&i.3k<9||i.4F&&i.4F<2||i.5H&&i.5H<9n,x=K(){R e=[[-1,-1],[0,-1],[1,-1],[-1,0],[0,0],[1,0],[-1,1],[0,1],[1,1]],t={3K:0,3H:0,42:1,4Z:1,3I:2,3J:2,43:5,51:5,44:8,46:8,47:7,52:7,48:6,49:6,4a:3,53:3};15 K(n,r,i,s){R o=e[t[r]],u=e[t[i]],a=[19.5Z(19.2y(o[0]-u[0])*.5)?-1:1,19.5Z(19.2y(o[1]-u[1])*.5)?-1:1];15!m.34(r)&&m.34(i)&&!s&&(m.2G(i)=="1K"?a[0]=0:a[1]=0),{x:a[0]*n.x,y:a[1]*n.y}}}();15{1r:T,7E:f,7s:n,7t:s,7F:S,7u:x,6f:h}}(),C.2u.4L={x:0,y:0},e(1t).6K(K(){R t=C.2u;e(1t).3N("5c",K(e){t.4L={x:e.5A,y:e.6z}})}),C.4V=K(){K t(){e(1t.3a).1V(e(1t.1Z("29")).1U("9o").1V(e(1t.1Z("29")).1U("3x").1V(e(J.1g=1t.1Z("29")).1U("7G"))))}K n(t){15{11:e(t).5P(),14:e(t).5Q()}}K i(t){R r=n(t),i=t.4D;15 i&&e(i).1l({11:r.11+"2r"})&&n(t).14>r.14&&r.11++,e(i).1l({11:"5W%"}),r}K s(t,n,i){J.1g||J.1L();R s=t.17,o=e.1i({1H:!1},1Y[3]||{});(s.7H||r.2h(n))&&!e(n).1W("7I")&&(s.7H&&e.1m(n)=="2o"&&(t.37=e("#"+n)[0],n=t.37),!t.3U&&n&&r.1e.5C(n)&&(e(t.37).1W("7J",e(t.37).1l("7K")),t.3U=1t.1Z("29"),e(t.37).68(e(t.3U).1F())));R u=1t.1Z("29");e(J.1g).1V(e(u).1U("75 9p").1V(n)),r.2h(n)&&e(n).1S(),s.1X&&e(u).1U("9q"+t.17.1X);R a=e(u).61("7L[4f]").9r(K(){15!e(J).3d("14")||!e(J).3d("11")});18(a.2f>0&&!t.1E("3z")){t.25("3z",!0),s.1H&&(!o.1H&&!t.1H&&(t.1H=t.6g(s.1H)),t.1E("1J")&&(t.1c(),e(t.1g).1S()),t.1H.6h());R f=0,l=19.1Q(9s,(a.2f||0)*9t);t.2c("3z"),t.3V("3z",e.1s(K(){a.1u(K(){J.6i=K(){}});18(f>=a.2f)15;J.5d(t,u),i&&i()},J),l),e.1u(a,e.1s(K(n,r){R s=2F 9u;s.6i=e.1s(K(){s.6i=K(){};R n=s.11,o=s.14,l=e(r).3d("11"),c=e(r).3d("14");18(!l||!c)!l&&c?(n=19.20(c*n/o),o=c):!c&&l&&(o=19.20(l*o/n),n=l),e(r).3d({11:n,14:o}),f++;f==a.2f&&(t.2c("3z"),t.1H&&(t.1H.1z(),t.1H=1p),t.1E("1J")&&e(t.1g).1F(),J.5d(t,u),i&&i())},J),s.4f=r.4f},J))}1C J.5d(t,u),i&&i()}K o(t,n){R r=i(n),s={11:r.11-(2M(e(n).1l("2g-12"))||0)-(2M(e(n).1l("2g-1N"))||0),14:r.14-(2M(e(n).1l("2g-13"))||0)-(2M(e(n).1l("2g-1O"))||0)};t.17.3e&&e.1m(t.17.3e)=="2v"&&s.11>t.17.3e&&(e(n).1l({11:t.17.3e+"2r"}),r=i(n)),t.1n.2E=r,e(t.3f).7M(n)}15{1L:t,3W:s,5d:o,63:i}}(),e.1i(k.3A,K(){K t(e,t,n){J.1n.39[e]=r.4z(t,n)}K n(e){15 J.1n.39[e]}K i(e){J.1n.39[e]&&(1I.6b(J.1n.39[e]),4e J.1n.39[e])}K s(){e.1u(J.1n.39,K(e,t){1I.6b(t)}),J.1n.39=[]}K o(t,n,r,i){n=n;R s=e.1s(r,i||J);J.1n.5u.2n({1e:t,7N:n,7O:s}),e(t).3N(n,s)}K u(){e.1u(J.1n.5u,K(t,n){e(n.1e).7P(n.7N,n.7O)})}K a(e,t){J.1n.2m[e]=t}K l(e){15 J.1n.2m[e]}K c(){J.2B(J.1e,"4h",J.5e),J.2B(J.1e,"4W",e.1s(K(e){J.6j(e)},J)),J.17.2J&&e.1u(J.17.2J,e.1s(K(t,n){R r=!1;n=="2z"&&(J.17.21&&e.1u(J.17.21,K(e,t){18(t.1e=="4y"&&t.2q=="2z")15 r=!0,!1}),J.25("5v",r)),J.2B(J.1e,n,n=="2z"?r?J.32:J.1S:e.1s(K(){J.7Q()},J))},J)),J.17.21?e.1u(J.17.21,e.1s(K(t,n){R r;1P(n.1e){1d"4y":18(J.1E("5v")&&n.2q=="2z")15;r=J.1e;1y;1d"1x":r=J.1x}18(!r)15;J.2B(r,n.2q,n.2q=="2z"?J.1F:e.1s(K(){J.6k()},J))},J)):J.17.7R&&J.17.2J&&!e.6l("2z",J.17.2J)>-1&&J.2B(J.1e,"4W",e.1s(K(){J.2c("1S")},J));R t=!1;!J.17.9v&&J.17.2J&&((t=e.6l("5c",J.17.2J)>-1)||e.6l("7S",J.17.2J)>-1)&&J.1x=="2L"&&J.2B(J.1e,t?"5c":"7S",K(e){18(!J.1E("4x"))15;J.1c(e)})}K h(){J.2B(J.1g,"4h",J.5e),J.2B(J.1g,"4W",J.6j),J.2B(J.1g,"4h",e.1s(K(){J.5f("4q")||J.1S()},J)),J.17.21&&e.1u(J.17.21,e.1s(K(t,n){R r;1P(n.1e){1d"1A":r=J.1g}18(!r)15;J.2B(r,n.2q,n.2q.3b(/^(2z|5c|4h)$/)?J.1F:e.1s(K(){J.6k()},J))},J))}K p(e,t,n){R r=b.1r(J.1e);r&&r.56(e,t,n)}K d(e){R t=b.1r(J.1e);t&&t.4g(e)}K v(){J.4g(J.17.1q.1A)}K m(){e(J.1g=1t.1Z("29")).1U("3x"),J.7T()}K g(){J.1L();R e=b.1r(J.1e);e?e.1L():(2F w(J.1e),J.25("4x",!0))}K y(){18(J.1E("1L"))15;e(1t.3a).1V(e(J.1g).1l({12:"-5g",13:"-5g",2e:J.2e}).1V(e(J.4S=1t.1Z("29")).1U("9w")).1V(e(J.3f=1t.1Z("29")).1U("7G"))),e(J.1g).1U("9x"+J.17.1X),J.17.7x&&(e(J.1e).1U("7U"),J.2B(1t.7m,"2z",e.1s(K(t){18(!J.1J())15;R n=e(t.1x).57(".3x, .7U")[0];(!n||n&&n!=J.1g&&n!=J.1e)&&J.1F()},J))),1T.31.3Z&&(J.17.4r||J.17.3Q)&&(J.5h(J.17.4r),e(J.1g).1U("6m")),J.7V(),J.25("1L",!0),C.2X(J)}K E(){R t=J.2D,n;J.3U&&J.37&&((n=e(J.37).1W("7J"))&&e(J.37).1l({7K:n}),e(J.3U).68(J.37).1z(),J.3U=1p)}K S(){r.3X(e.1s(K(){J.7W()},J)),J.7X(),J.6n(),r.3X(e.1s(K(){e(J.1g).61("7L[4f]").7P("9y")},J)),b.1z(J.1e),J.1E("1L")&&J.1g&&(e(J.1g).1z(),J.1g=1p);R t="5t",n;(n=e(J.1e).1W(t))&&e(J.1e).3d("5s",n).7Y("5t"),e(J.1e).7Y("2l-1R")}K x(t){R n=e.1i({4s:J.17.4s,1H:!1},1Y[1]||{});J.1L(),J.1E("1J")&&e(J.1g).1F(),C.4V.3W(J,t,e.1s(K(){R t=J.1E("1J");t||J.25("1J",!0),J.7Z(),t||J.25("1J",!1),J.1E("1J")&&(e(J.1g).1F(),J.1c(),J.5i(),e(J.1g).1S()),J.25("3j",!0),n.4s&&n.4s(J.3f.5j,J.1e),n.5k&&n.5k()},J),{1H:n.1H})}K T(t){18(J.1E("2t")||J.17.2b.4o&&J.1E("3j"))15;J.25("2t",!0),J.17.1H&&(J.1H?J.1H.6h():(J.1H=J.6g(J.17.1H),J.25("3j",!1)),J.1c(t)),J.1n.2t&&(J.1n.2t.80(),J.1n.2t=1p),J.1n.2t=e.2b({9z:J.2D,1m:J.17.2b.1m,1W:J.17.2b.1W||{},81:J.17.2b.81||"7M",9A:e.1s(K(t,n,r){18(r.9B===0)15;J.3W(r.9C,{1H:J.17.1H&&J.1H,5k:e.1s(K(){J.25("2t",!1),J.1E("1J")&&J.17.5l&&J.17.5l(J.3f.5j,J.1e),J.1H&&(J.1H.1z(),J.1H=1p)},J)})},J)})}K N(){R t=1t.1Z("29");e(t).1W("7I",!0);R n=6e.4J(t,e.1i({},1Y[0]||{})),r=6e.5S(t);15 e(t).1l(f(r)),J.3W(t,{4s:!1,5k:K(){n.6h()}}),n}K L(){18(!J.1E("1L")||J.17.2e)15;R t=C.7p();t&&t!=J&&J.2e<=t.2e&&e(J.1g).1l({2e:J.2e=t.2e+1})}K A(){R e=b.1r(J.1e);e&&(e.2N(),J.1J()&&J.1c())}K O(e){18(!1T.31.3Z)15;e=e||0;R t=J.1g.9D;t.9E=e+"5m",t.9F=e+"5m",t.9G=e+"5m",t.9H=e+"5m"}K M(t){J.2c("1F"),J.2c("4q");18(J.1E("1J")||J.5f("1S"))15;J.3V("1S",e.1s(K(){J.2c("1S"),J.1S(t)},J),J.17.7R||1)}K 2a(t){J.2c("1F"),J.2c("4q");18(J.1J())15;18(e.1m(J.2D)=="K"||e.1m(J.1n.5n)=="K"){e.1m(J.1n.5n)!="K"&&(J.1n.5n=J.2D);R n=J.1n.5n(J.1e)||!1;n!=J.1n.5w&&(J.1n.5w=n,J.25("3j",!1),J.6n()),J.2D=n;18(!n)15}J.17.9I&&C.4K(),J.25("1J",!0),J.17.2b?J.82(t):J.1E("3j")||J.3W(J.2D),J.1E("4x")&&J.1c(t),J.5i(),J.17.5o&&r.3X(e.1s(K(){J.5e()},J)),e.1m(J.17.5l)=="K"&&(!J.17.2b||J.17.2b&&J.17.2b.4o&&J.1E("3j"))&&J.17.5l(J.3f.5j,J.1e),1T.31.3Z&&(J.17.4r||J.17.3Q)&&(J.5h(J.17.4r),e(J.1g).1U("83").84("6m")),e(J.1g).1S()}K D(){J.2c("1S");18(!J.1E("1J"))15;J.25("1J",!1),1T.31.3Z&&(J.17.4r||J.17.3Q)?(J.5h(J.17.3Q),e(J.1g).84("83").1U("6m"),J.3V("4q",e.1s(J.6o,J),J.17.3Q)):J.6o(),J.1n.2t&&(J.1n.2t.80(),J.1n.2t=1p,J.25("2t",!1))}K P(){18(!J.1E("1L"))15;e(J.1g).1l({12:"-5g",13:"-5g"}),C.7q(),e.1m(J.17.85)=="K"&&!J.1H&&J.17.85(J.3f.5j,J.1e)}K H(){J.2c("1S");18(J.5f("1F")||!J.1E("1J"))15;J.3V("1F",e.1s(K(){J.2c("1F"),J.2c("4q"),J.1F()},J),J.17.9J||1)}K B(e){J[J.1J()?"1F":"1S"](e)}K F(){15 J.1E("1J")}K I(){J.25("4w",!0),J.1E("1J")&&J.5i(),J.17.5o&&J.2c("6p")}K q(){J.25("4w",!1),J.17.5o&&J.3V("6p",e.1s(K(){J.2c("6p"),J.1E("4w")||J.1F()},J),J.17.5o)}R k=K(t){18(!J.1J())15;R n;18(J.17.1x=="2L"){R i=C.2u.6f(t),s=C.2u.4L;18(!i){18(s.x||s.y)J.1n.2q={x:s.x,y:s.y};1C 18(!J.1n.2q){R o=C.2u.7F(J.1e);J.1n.2q={x:o.12,y:o.13}}n=1p}1C s.x||s.y?(J.1n.2q={x:s.x,y:s.y},n=1p):n=t}1C n=J.1x;C.2u.7E(J,J.17.1q.1A,n,J.17.1q.1x);18(t&&C.2u.6f(t)){R u={11:e(J.1g).7A(),14:e(J.1g).7B()},a=r.5z(t),o=r.1e.4E(J.1g);a.x>=o.12&&a.x<=o.12+u.11&&a.y>=o.13&&a.y<=o.13+u.14&&r.3X(e.1s(K(){J.2c("1F")},J))}};15{1L:y,6w:m,7Z:g,7T:c,7V:h,1S:2a,1F:D,6o:P,32:B,1J:F,7Q:M,6k:H,5h:O,25:a,1E:l,5e:I,6j:q,5f:n,3V:t,2c:i,7X:s,2B:o,7W:u,56:p,4g:d,9K:v,2N:A,3W:x,82:T,6g:N,1c:k,5i:L,6n:E,1z:S}}()),1T.3n()})(3Y)',62,605,'|||||||||||||||||||||||||||||||||||||||||||||this|function|||||||var||||||||||width|left|top|height|return||options|if|Math|dimensions|lineTo|position|case|element|border|container|stem|extend|background|radius|css|type|_cache|shadow|null|hook|get|proxy|document|each|closeButton|offset|target|break|remove|tooltip|ceil|else|bubble|getState|hide|opacity|spinner|window|visible|horizontal|build|color|right|bottom|switch|max|uid|show|Tipped|addClass|append|data|skin|arguments|createElement|round|hideOn|arc|_hookPosition||setState|getTooltip|beginPath|closePath|div|_|ajax|clearTimer||zIndex|length|padding|isElement|vertical|getOrderLayout|for|tipped|states|push|string|size|event|px|_globalAlpha|xhr|Position|number|middle|box|abs|click|Skins|setEvent|180|content|contentDimensions|new|getOrientation|anchor|tooltips|showOn|globalAlpha|mouse|parseInt|refresh|fillStyle|hex2fill|center|iframeShim|closeButtonShadow|bubbleCanvas|blurs|containment|PI|add|blur|scripts|split|support|toggle|fill|isCenter|cleanup|cornerOffset|inlineContent|_stemCorrection|timers|body|match|canvas|attr|maxWidth|contentElement|shadows|getSkin|_adjustment|updated|IE|indexOf|getContext|init|devicePixelRatio|moveTo|charAt|toLowerCase|diameter|hookPosition|layout|stemLayout|sides|t_Tooltip|constructor|preloading_images|prototype|getVisible|resize|x1|y1|x2|y2|topleft|topright|righttop|lefttop|math|getLayout|bind|test|defaultSkin|fadeOut|contained|overlap|tt|inlineMarker|setTimer|update|defer|jQuery|cssTransitions|items|createFillStyle|topmiddle|rightmiddle|rightbottom||bottomright|bottommiddle|bottomleft|leftbottom|leftmiddle|regex|getBorderDimensions|correction|delete|src|setHookPosition|mouseenter|getStemLayout|_corrections|transition|Stem|closeButtonCanvas|boolean|cache|sideOffset|fadeTransition|fadeIn|afterUpdate|cos|000|startingZIndex|active|skinned|self|delay|cumulativeScrollOffset|scrollTop|scrollLeft|parentNode|cumulativeOffset|Gecko|Chrome|pow|touch|create|hideAll|mouseBuffer|viewport|min|G_vmlCanvasManager|getCenterBorderDimensions|substring|skins|skinElement|prepare|order|UpdateQueue|mouseleave|rotate|borderRadius|topcenter||rightcenter|bottomcenter|leftcenter|corrections||setHookPositionAndStemCorrection|closest|_resizeTimer|_getTooltip|_remove|selector|mousemove|_updateTooltip|setActive|getTimer|10000px|setFadeDuration|raise|firstChild|callback|onShow|ms|contentFunction|hideAfter|console|in|Object|title|tipped_restore_title|events|toggles|fnCallContent|call|apply|pointer|pageX|while|isAttached|RegExp|parseFloat|Opera|opera|WebKit|required|available|findElement|setDefaultSkin|setStartingZIndex|isVisibleByElement|undefined|innerWidth|innerHeight|getSide|getDimensions|getBubbleLayout|nullifyCornerOffset|replace|100|defaultCloseButton|hoverCloseButton|floor|prepend|find|auto|getMeasureElementDimensions|drawCloseButtonState|default|hover|_drawBackgroundPath|before|dark|getByTooltipElement|clearTimeout|reset|CloseButtons|Spinners|isPointerEvent|insertSpinner|play|onload|setIdle|hideDelayed|inArray|t_hidden|_restoreInlineContent|_hide|idle|warn|sqrt|_stemPosition|createOptions|getAttribute|getElementById|_preBuild|Array|concat|pageY|version|AppleWebKit|MobileSafari|check|Za|checked|notified|try|DocumentTouch|catch|ready|startDelegating|removeDetached|drawRoundedRectangle|fillRect|isArray|Gradient|addColorStops|positions|toOrientation|side|toDimension|isCorner|atan|red|green|blue|360|drawBubble|drawCloseButton|createHookCache|t_ContentContainer|first|25000px|setStemCorrection|setAdjustment|t_Close|closeButtonShift|closeButtonMouseover|closeButtonMouseout|CloseButton|corner|stemOffset|backgroundRadius|_drawBorderPath|setGlobalAlpha|drawBackground|getBlurOpacity|documentElement|onWindowResize|is|getHighestTooltip|resetZ|base|getInversedPosition|getTooltipPositionFromTarget|adjustOffsetBasedOnHooks|closeButtonSkin|flip|hideOnClickOutside|typeof|adjustment|outerWidth|outerHeight|et|rt|set|getAbsoluteOffset|t_Content|inline|isSpinner|tipped_restore_inline_display|display|img|html|eventName|handler|unbind|showDelayed|showDelay|touchmove|createPreBuildObservers|t_hideOnClickOutside|createPostBuildObservers|clearEvents|clearTimers|removeData|_buildSkin|abort|dataType|ajaxUpdate|t_visible|removeClass|onHide|log|object|setAttribute|slice|wrap|nodeType|setTimeout|do|exec|attachEvent|MSIE|KHTML|rv|Apple|Mobile|Safari|navigator|userAgent|fn|jquery|z_|z0|requires|_t_uid_|ontouchstart|instanceof|WebKitTransitionEvent|TransitionEvent|OTransitionEvent|createEvent|scale|initElement|drawPixelArray|createLinearGradient|addColorStop|spacing|rgba|join|fff|255|hue|saturation|brightness|0123456789abcdef|hex2rgb|getSaturatedBW|init_|t_Bubble|iframe|t_iframeShim|frameBorder|javascript|15000px|t_CloseButtonShift|lineCap|t_CloseState||translate|stemCorrection|270|lineWidth|sin|setOpacity|getCenterBorderDimensions2|acos|t_Shadow|t_ShadowBubble|t_CloseButtonShadow|999999|touchstart|void|delegate|close|preventDefault|stopPropagation|200|getBySelector|outside|move|530|t_UpdateQueue|t_clearfix|t_Content_|filter|8e3|750|Image|fixed|t_Skin|t_Tooltip_|load|url|success|status|responseText|style|MozTransitionDuration|webkitTransitionDuration|OTransitionDuration|transitionDuration|hideOthers|hideDelay|resetHookPosition'.split('|'),0,{}));