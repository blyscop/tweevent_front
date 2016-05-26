var Drag = {
        obj : null,

        init : function(o) {
                    o.onmousedown = Drag.start;
                    o.onDragEnd = new Function();
                },

				start : function(e) {
						e = Drag.fixE(e);
						var o = Drag.obj = this;
						o.lastMouseX = e.clientX;
						o.lastMouseY = e.clientY;
						document.onmousemove = Drag.drag;
						document.onmouseup = Drag.end;
						return false;
				},

				drag : function(e) {
						e = Drag.fixE(e);
						var o = Drag.obj;
						/*On récupère l'id du DIV qui englobe le DIV de "travail"*/
						var w = document.getElementById(o.id+"_WD");
						var newX = parseInt(o.style.left) + e.clientX - o.lastMouseX;
						var newY = parseInt(o.style.top) + e.clientY - o.lastMouseY;
						w.style.left = o.style.left = newX + "px";
						w.style.top = o.style.top = newY + "px";
						Drag.obj.lastMouseX = e.clientX;
						Drag.obj.lastMouseY = e.clientY;
						return false;
				},

				end : function(e) {
						e = Drag.fixE(e);
						document.onmousemove = null;
						document.onmouseup = null;
						Drag.obj.onDragEnd(e.clientX, e.clientY);
						Drag.obj = null;
				},


				fixE : function(e) {
						if (typeof e == 'undefined') e = window.event;
						return e;
				}
		};