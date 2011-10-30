var ULABS = ULABS || {};

ULABS.bindReady = function (handler){

	var called = false;

	function ready() { 
		if (called) {
			return;
		}
		called = true;
		handler();
	}

	if ( document.addEventListener ) { 
		document.addEventListener( "DOMContentLoaded", function(){
			ready();
		}, false );
	} else if ( document.attachEvent ) {  

		if ( document.documentElement.doScroll && window == window.top ) {
			function tryScroll(){
				if (called) {
					return
				}
				if (!document.body) {
					return
				}
				try {
					document.documentElement.doScroll("left");
					ready();
				} catch (e) {
					setTimeout(tryScroll, 0);
				}
			}
			tryScroll();
		}

		document.attachEvent("onreadystatechange", function() {

			if ( document.readyState === "complete" ) {
				ready();
			}
		});
	}

    if (window.addEventListener) {
        window.addEventListener('load', ready, false);
	} else if (window.attachEvent) {
        window.attachEvent('onload', ready);
	}
}

ULABS.readyList = [];

ULABS.onReady = function (handler) {

	if (!ULABS.readyList.length) {
		ULABS.bindReady (function() {
			for(var i = 0; i < ULABS.readyList.length; i++) {
				ULABS.readyList[i]();
			}
		});
	}

	ULABS.readyList.push(handler);
}

ULABS.onReady (function() {
		
	ULABS.namespace = function(namespaceString) {
		
		var parts = namespaceString.split('.'),
			parent = ULABS;
			
		if (parts[0] === "ULABS") {
			parts = parts.slice(1);
		}
		
		for (var i = 0, length = parts.length; i < length; i += 1) {
			if (typeof parent[parts[i]] === "undefined") {
				parent[parts[i]] = {};
			}
			parent = parent[parts[i]];
		}
		
		return parent;
	};
	
	ULABS.namespace('ULABS.dom');
	
	ULABS.dom.init = (function () {
		if(document.getElementsByClassName) {
 
		ULABS.dom.getElementsByClass = function (classList, node) {    
			return (node || document).getElementsByClassName(classList);
		}
	 
		} else {
		 
			ULABS.dom.getElementsByClass = function (classList, node) {            
				var node = node || document,
					list = node.getElementsByTagName('*'), 
					length = list.length,  
					classArray = classList.split(/\s+/), 
					classes = classArray.length, 
					result = [], i,j;
					
				for (i = 0; i < length; i++) {
					for (j = 0; j < classes; j++)  {
						if (list[i].className.search('\\b' + classArray[j] + '\\b') != -1) {
							result.push(list[i]);
							break;
						}
					}
				}
			 
				return result;
			}
		}
	}());
	
	ULABS.dom.addClass = (function (o, c) {
		var re = new RegExp("(^|\\s)" + c + "(\\s|$)", "g");
		if (re.test(o.className)) {
			return;
		}
		o.className = (o.className + " " + c).replace(/\s+/g, " ")
											 .replace(/(^ | $)/g, "");
	});
	
	ULABS.dom.removeClass = (function (o, c){
		var re = new RegExp("(^|\\s)" + c + "(\\s|$)", "g");
		o.className = 
			o.className.replace(re, "$1").replace(/\s+/g, " ")
					   .replace(/(^ | $)/g, "");
	});
		
	ULABS.dom.setTextContent = (function (node, text) {
		while (node.firstChild !== null) {
			node.removeChild (node.firstChild); 
		}
		node.appendChild (document.createTextNode(text));
	});
	
	ULABS.dom.getTextContent = (function (node) {
		var nodeText = node.innerText;
		
		if (nodeText == undefined) {
			nodeText = node.innerHTML.replace (/<[^>]+>/g,"");
		}
		return nodeText;
	});
	
	ULABS.dom.node = {};
	ULABS.dom.getChildNodeById = (function (nodeList, id) {
		for (var i = 0, length = nodeList.length; i < length; i += 1) {
			if (nodeList[i].id === id) {
				ULABS.dom.node = nodeList[i];
			}
			if (nodeList[i].hasChildNodes) {
				ULABS.dom.getChildNodeById (nodeList[i].childNodes, id);
			}
		}
		return ULABS.dom.node;
	});

	ULABS.namespace('ULABS.utilities.Project');
	
	ULABS.dom.initProjectDomObject = function () {
		var dom = ULABS.dom,
			previewBlock = document.getElementById("workPreview"),
			infoBlockElements,
			result = undefined;
			
		if (previewBlock != undefined){
			infoBlockElements = document.getElementById('whom').childNodes;
			result = {
					title: dom.getChildNodeById (infoBlockElements, 'title'),
					type: dom.getChildNodeById (infoBlockElements, 'work_info_type'),
					customer: dom.getChildNodeById (infoBlockElements, 'work_info_customer'),
					task: dom.getChildNodeById (infoBlockElements, 'work_info_task'),
					year: dom.getChildNodeById (infoBlockElements, 'work_info_year'),
					team: document.getElementById ('who'),
					fade: document.getElementById ('fade'),
					preview: previewBlock,
					previewPhoto: dom.getChildNodeById (previewBlock.childNodes, 'big_img')
			};
		}
		
		return result;
	};
	
	ULABS.utilities.Project = (function () {
	
		var	dom = ULABS.dom,
			projectJsonObject = {},
			projectDomObject = ULABS.dom.initProjectDomObject();
		
			createTeamBlockInnerHtml = function (){
				var teamBlockInnerHtml = "";
				for (var obj in projectJsonObject.team) {
					if (projectJsonObject.team.hasOwnProperty(obj)) {
						teamBlockInnerHtml = teamBlockInnerHtml + 
								"<span>" + projectJsonObject.team[obj].member['name_' + projectJsonObject.lang] + 
								" - " + projectJsonObject.team[obj].role['role_' + projectJsonObject.lang] + 
								"</span><br/>"; 
					}
				}
				return teamBlockInnerHtml;
			},
		
			printProjectParams = function () {
				projectDomObject.previewPhoto.setAttribute ('src', projectJsonObject.imgSrc);
				dom.setTextContent (projectDomObject.title, projectJsonObject['title_' + projectJsonObject.lang]);
				dom.setTextContent (projectDomObject.type, projectJsonObject['type_' + projectJsonObject.lang]);
				dom.setTextContent (projectDomObject.customer, projectJsonObject['customer_' + projectJsonObject.lang]);
				dom.setTextContent (projectDomObject.task, projectJsonObject['task_' + projectJsonObject.lang]);
				dom.setTextContent (projectDomObject.year, projectJsonObject.year);
				projectDomObject.team.innerHTML = projectJsonObject.teamBlockInnerHtml;	
			},
			
			showPreview = function () {
				projectDomObject.fade.style.display = 'block'; 
				projectDomObject.preview.style.display = 'block'; 
			},
			
			clearPreview = function () {
				projectDomObject.previewPhoto.setAttribute('src', '');
				dom.setTextContent (projectDomObject.title, '');
				dom.setTextContent (projectDomObject.type, '');
				dom.setTextContent (projectDomObject.customer, '');
				dom.setTextContent (projectDomObject.task, '');
				dom.setTextContent (projectDomObject.year, '');
				projectDomObject.team.innerHTML = '';
			},
			
			hidePreview = function () {
				projectDomObject.fade.style.display = 'none';
				projectDomObject.preview.style.display = 'none';
			},
					
			getProjectById = function (id) {
				var ajax = ULABS.ajax,
					response;
					
				ajax.createXmlHttpRequestObject();
				response = ajax.httpRequest("/async/project/" + id);
				projectJsonObject = ULABS.ajax.parseJSON (response);
				projectJsonObject.lang = ULABS.dom.getTextContent(document.getElementById('act_lang'));	
				projectJsonObject.imgSrc = document.getElementById(id).getElementsByTagName('a')[0].getAttribute('href');
				projectJsonObject.teamBlockInnerHtml = createTeamBlockInnerHtml ();
				printProjectParams ();
			},
			
			changeActivePreviewMenuPoint = function () {
				var projectPreviewFilterMenu = document.getElementById('worksMenu');
					activeMenuItem = ULABS.dom.getElementsByClass ("active", projectPreviewFilterMenu)[0];

				ULABS.dom.removeClass(activeMenuItem, 'active');
				ULABS.dom.addClass(this, 'active');
			},
			
			toggleProjectImage = function(){
				var activeProject = ULABS.dom.getElementsByClass('workImg', this)[0];
				activeProject.style.display = (
					activeProject.style.display == 'none' ? 
					activeProject.style.display = 'block' : 
					activeProject.style.display = 'none'
				);
			},
			
			openProject = function () {
				var id = this.id;
					clearPreview();
					getProjectById(id);
					showPreview();
					ULABS.utilities.Project.Navigation.refresh(id);			
				return false;
			}
			
		return {
		
			showPreview: showPreview,
			clearPreview: clearPreview,
			hidePreview: hidePreview,
			getProjectById: getProjectById,
			changeActivePreviewMenuPoint: changeActivePreviewMenuPoint,
			toggleProjectImage: toggleProjectImage,
			openProject: openProject
			
		};
		
	}());
	
	ULABS.namespace('ULABS.utilities.Project.Navigation');
	
	ULABS.utilities.Project.Navigation = (function () {
		var navigation = {};
			
			getProjectList = function(id) {
				var ids = [],
					dom = ULABS.dom,
					selectedWork = ULABS.dom.getChildNodeById(dom.getElementsByClass('works'), id);
					works = ULABS.dom.getElementsByClass ('work', selectedWork.parentNode);
					
				for (var work in works) {
					if (works.hasOwnProperty(work) && works[work].id != undefined) {
						ids.push(works[work].id);
					}
				}

				return ids;
			},
			
			getProjectNavigation = function (projectList, value) {
				for (var i = 0, length = projectList.length; i < length; i += 1) {
					if (projectList[i] === value) {
						navigation.prev = _getPrevProject (i);
						navigation.current = i;
						navigation.next = _getNextProject (i, length - 1);
					}
				}
			},
			
			_getPrevProject = function (projectNumber) {
				if (projectNumber != 0) {
					projectNumber -= 1;
				} 
				return projectNumber;
			},
			
			_getNextProject = function (projectNumber, projectCount) {
				if (projectNumber != projectCount) {
					projectNumber += 1;
				}
				return projectNumber;
			},
			
			checkProjectListLimit = function (id) {
				var result = false,
					projectList = getProjectList(id),
					prevWork = 0,
					prevNavPosition = navigation.current;
					
				getProjectNavigation(projectList, id);
				if ((prevNavPosition == 0 && navigation.current == 0) 
					|| (prevNavPosition == projectList.length - 1 
					&& navigation.current == projectList.length - 1)) {
					result = true
				}
				return result;
			},
			
			refresh = function (id) {
				var projectList = getProjectList (id),
					dom = ULABS.dom;
				
				getProjectNavigation (projectList, id);
				dom.getElementsByClass('nextWork', document)[0].id = projectList[navigation.next];
				dom.getElementsByClass('prevWork', document)[0].id = projectList[navigation.prev];
			}
			
		return {
			
			refresh: refresh,
			keyboardSwitchProject: function (e) {
				var key = ULABS.event.Keyboard.getKey(e),
					previewBlock = document.getElementById('workPreview');

				if (key != "" && previewBlock.style.display != "none") {
					switch(key) {
						case 'up':
						case 'right':
							ULABS.dom.getElementsByClass('nextWork', document)[0].onclick();
						break;					
						
						case 'left':
						case 'down':
							ULABS.dom.getElementsByClass('prevWork', document)[0].onclick();
						break;
						
						case 'escape':
							previewBlock.style.display = 'none';
							document.getElementById('fade').style.display = 'none';
						break
					}
				}
			},
			
			switchProject: function () {
				var id = this.id,
					projectUtils = ULABS.utilities.Project;
					
				if (!checkProjectListLimit(id)) {
					projectUtils.clearPreview();
					projectUtils.getProjectById(id);
					projectUtils.showPreview();
					refresh(id);	
				}
			}
		}
	}());
	
	ULABS.namespace('ULABS.event');
	
	ULABS.event = (function(){
	
		addEvent = function (elem, eventType, fn) {
			if (elem != undefined) {
				if (elem.addEventListener) {
					elem.addEventListener(eventType, fn, false)
					return fn;
				}
				
				iefn = function() {
					fn.call(elem) 
				} 
				elem.attachEvent('on' + eventType, iefn)
				return iefn;
			}
		},
		 
		removeEvent = function (elem, eventType, fn) {
			if (elem != undefined) {
				if (elem.addEventListener) {
					elem.removeEventListener(eventType, fn, false)
					return;
				}
				elem.detachEvent('on' + eventType, fn);
			}
		}
		
		return {
			addEvent: addEvent,
			removeEvent: removeEvent
		}
		
	}());
	
	ULABS.event.Keyboard = (function () {
		
		getKeyValueByKeyCode = function (keyCode) {
			var keyValue = "";
			
			switch (keyCode) {
				case 27:
					keyValue = 'escape';
				break;	
			
				case 37:
					keyValue = 'left';
				break;				
				
				case 38:
					keyValue = 'up';
				break;				
				
				case 39:
					keyValue = 'right';
				break;				
				
				case 40:
					keyValue = 'down';
				break;
			}
			
			return keyValue;
		},
		
		getKey = function (e) {
			var keyCode = (window.event) ? event.keyCode : e.keyCode;
			return getKeyValueByKeyCode(keyCode);
		}
		
		return {
			getKey: getKey
		}
		
	}());
	
	ULABS.namespace ('ULABS.ajax');
	
	ULABS.ajax = (function () {
		var xmlHttp,
			response = null;
		
		createXmlHttpRequestObject = function () {
			var	xmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
											"MSXML2.XMLHTTP.5.0",
											"MSXML2.XMLHTTP.4.0",
											"MSXML2.XMLHTTP.3.0",
											"MSXML2.XMLHTTP",
											"Microsoft.XMLHTTP"
											);
				
			try {
				xmlHttp = new XMLHttpRequest();
			} catch (e) {
				for (var i = 0; i < xmlHttpVersions.length && !xmlHttp; i += 1) {
					try {
						xmlHttp = new ActiveXObject(xmlHttpVersions[i]);
					} catch(e) {}
				}
			}
			
			if (!xmlHttp) {
				alert ('Error creating the XMLHttpRequest object');
			}
		},
		
		httpRequest = function (url) {
			if (xmlHttp) {
				try {
					xmlHttp.open ("GET", url, false);
					xmlHttp.onreadystatechange = requestControl;
					xmlHttp.send (null);
					return response;
				} catch (e) {
					alert ('Can not connect to server: ' + e.toString());
				}
			}
		},
		
		requestControl = function () {
			var READY_STATE = 4,
				HTTP_STATUS_OK = 200;
				
			if (xmlHttp.readyState == READY_STATE) {
				if (xmlHttp.status == HTTP_STATUS_OK) {
					try {
						response = xmlHttp.responseText;
					} catch (e) {
						alert ('Error processing the server response: ' + e.toString());
					}
				} else {
					alert ('The problem with getting data from the server: ' + xmlHttp.statusText);
				}
			}
		},
	
		parseJSON = function (data) {
			var rvalidchars = /^[\],:{}\s]*$/,
				rvalidescape = /\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,
				rvalidtokens = /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
				rvalidbraces = /(?:^|:|,)(?:\s*\[)+/g;
			
			if (typeof data !== "string" || !data || data=='') {
				return null;
			}

			data = data.replace(/^\s+/, '');
			data = data.replace(/\s+$/, '');

			if (window.JSON && window.JSON.parse) {
				return window.JSON.parse(data);
			}
					
			if (rvalidchars.test(data.replace(rvalidescape, "@").replace(rvalidtokens, "]").replace(rvalidbraces, ""))) {
				return (new Function( "return " + data ))();
			}
		}
		
		return {
			parseJSON: parseJSON,
			createXmlHttpRequestObject: createXmlHttpRequestObject,
			httpRequest: httpRequest
		}
		
	}());
	
	ULABS.namespace ('ULABS.utilities.Form');
	
	ULABS.utilities.Form = (function (){
		var currentDefaultValue = "",
			defaultValueList = [
									"Пошук", "Search",
									"Ім'я", "Name",
									"Компанія", "Company",
									"E-mail","Е-пошта",
									"Телефон", "Phone",
									"Повідомлення", "Message"
								];
								
		isValueInDefaultValueList = function (value) {
			var result = false;
			
			for (var i = 0, length = defaultValueList.length; i < length; i += 1) {
				if (defaultValueList[i] === value) {
					result = true;
					break;
				}
			}
			return result;
		},
		
		isValidEmailAddress = function (email) {
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(email);
		},
		
		isValidPhoneNumber = function (phone) {
			var pattern = new RegExp(/^[0-9]*$/);
			return pattern.test(phone);
		},		
		
		clearInputDefaultValue = function () {
			if (isValueInDefaultValueList(this.value)) {
				currentDefaultValue = this.value;
				this.value = "";
			}
		},
		
		restoreInputDefaultValue = function () {
			if (isValueInDefaultValueList(this.value) || this.value === "") {
				this.value = document.getElementById('default_' + this.id).value;
			}
		},
		
		submitForm = function () {		
			this.parentNode.submit();
		},
		
		validateFormFieldValue = function (value, id) {
			var result = true;
			
			if (isValueInDefaultValueList(value) && value === "") {
				result = false;
			} else {
				if (id === "email") {
					if (!isValidEmailAddress(value)) {
						result = false;
					}
				}						
				if (id === "phone") {
					if (!isValidPhoneNumber(value)) {
						result = false;
					}
				}
			}
			
			return result;
		},
		
		ajaxRequestSendingMail = function () {
			var ajax = ULABS.ajax,
				name = document.getElementById("name").value,
				email = document.getElementById("email").value,
				message = document.getElementById("message").value,			
				phone = document.getElementById("phone").value,
				company = document.getElementById("company").value;
				
				ajax.createXmlHttpRequestObject();
				response = ajax.httpRequest ("/async/sendmail/?name=" + name + 
								  "&message=" + message + "&email=" + email +
								  "&phone=" + phone + "&company=" + company);
		},
		
		sendEmail = function () {
			var result = true;
			
			for (var field in ULABS.dom.formFiendList) {
				if (ULABS.dom.formFiendList.hasOwnProperty(field)) {
					if (
						!validateFormFieldValue (
													ULABS.dom.formFiendList[field].value, 
													ULABS.dom.formFiendList[field].id
											    )
					   ) 
					{
						result = false;
						break;
					}
				}
			}
			
			if (result) {
				ajaxRequestSendingMail();
			}
			
			return false;
		}
		
		
		return {
			clearInputDefaultValue: clearInputDefaultValue,
			restoreInputDefaultValue: restoreInputDefaultValue,
			submitForm: submitForm,
			sendEmail: sendEmail
		}
		
	}());
	
	ULABS.dom.works = ULABS.dom.getElementsByClass('work', document);
	
	ULABS.event.init = (function () {
	
			ULABS.event.addEvent(
				document.getElementById('workPreviewClose'),
				'click',
				ULABS.utilities.Project.hidePreview
			);	
			
			ULABS.event.addEvent(
				document.getElementById('fade'),
				'click',
				ULABS.utilities.Project.hidePreview
			);		
			
			ULABS.event.addEvent(
				document,
				'keydown',
				ULABS.utilities.Project.Navigation.keyboardSwitchProject
			);
			
			ULABS.event.addEvent(
				document.getElementById('searchInputField'),
				'focus',
				ULABS.utilities.Form.clearInputDefaultValue
			);
			
			ULABS.event.addEvent(
				document.getElementById('searchInputField'),
				'blur',
				ULABS.utilities.Form.restoreInputDefaultValue
			);
			
			ULABS.event.addEvent(
				document.getElementById('button'),
				'click',
				ULABS.utilities.Form.submitForm
			);
			
			if (document.getElementById('workPreview') != undefined) {
				for (var work in ULABS.dom.works) {
					if (ULABS.dom.works.hasOwnProperty(work)) {
						ULABS.dom.works[work].onclick = 
											ULABS.utilities.Project.openProject;
						ULABS.dom.works[work].onmouseover = 
											ULABS.utilities.Project.toggleProjectImage;			
						ULABS.dom.works[work].onmouseout = 
											ULABS.utilities.Project.toggleProjectImage;
					}
				}
				
				ULABS.dom.getElementsByClass('nextWork', document)[0].onclick = 
											ULABS.utilities.Project.Navigation.switchProject;
				ULABS.dom.getElementsByClass('prevWork', document)[0].onclick = 
											ULABS.utilities.Project.Navigation.switchProject;
					
				ULABS.dom.projectPreviewFilterMenu = 
							document.getElementById('worksMenu').getElementsByTagName('li');
				
				for (var menuItem in ULABS.dom.projectPreviewFilterMenu) {
					ULABS.dom.projectPreviewFilterMenu[menuItem].onclick = 
										ULABS.utilities.Project.changeActivePreviewMenuPoint;
				}
			}
			
			if (document.getElementById('contacts') != undefined) {
				ULABS.dom.formFiendList = 
									ULABS.dom.getElementsByClass ('contactFormField', document);
				
				for (var field in ULABS.dom.formFiendList) {
					if (ULABS.dom.formFiendList.hasOwnProperty(field)) {
						ULABS.dom.formFiendList[field].onfocus = 
											ULABS.utilities.Form.clearInputDefaultValue;						
						ULABS.dom.formFiendList[field].onblur = 
											ULABS.utilities.Form.restoreInputDefaultValue;
					}
				}
				
				ULABS.event.addEvent(
					document.getElementById('send_button'),
					'click',
					ULABS.utilities.Form.sendEmail
				);
				
				document.getElementById('map').onclick = function () {
					document.getElementsByTagName('iframe')[0].style.display = 'block';
				}
			}
	}());

});