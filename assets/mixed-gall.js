/**
 * выгрузить в инпут с данные из сортируемого списка
 *
 * @param galleryBlock - jquery object
 */
function updateInputFromSortableList(galleryBlock) {
	console.log('updateInputFromSortableList');
	var
		galeryElementArr = [],
		sortableWrapper = getSortableWrapper(galleryBlock),
		activeformInput = getActiveformInput(galleryBlock);

	sortableWrapper.find('li').each(function (indx, element) {
		var item = $(element);
		galeryElementArr.push(item.attr('title'));
	});
	activeformInput.html('');
	galeryElementArr.forEach(function (item, i, arr) {
		activeformInput.append('<option value="' + item + '" selected="">' + item + '</option>');
	});
	setTimeout(function () {
		selectAllOptionsInInputBlock(activeformInput);
	}, 1);
	//console.log(galeryElementArr);
}

/**
 * обновить сортируемый список из инпута с данными
 *
 * @param galleryBlock - jquery object
 */
function updateSortableListFromInput(galleryBlock) {
	console.log('updateSortableListFromInput');
	var sortableWrapper, activeformInput, galeryElementArr;

	sortableWrapper = getSortableWrapper(galleryBlock);
	activeformInput = getActiveformInput(galleryBlock);
	sortableWrapper.html('');

	galeryElementArr = [];
	activeformInput.find('option').each(function (indx, element) {
		galeryElementArr.push($(element).val());
	});

	if (!galeryElementArr.length) {
		console.log('no items');
		return;
	}

	galeryElementArr.forEach(function (item, i, arr) {
		addNewItemToSortableWrapper(galleryBlock, item, true);
	});

}
/**
 * добавляет в список ручной сортировки новый элемент
 *
 * @param galleryBlock
 * @param item
 * @param insertAfter
 */
function addNewItemToSortableWrapper(galleryBlock, item, insertAfter) {
	var
		mediaUrl = getImageFromMediaUrl(item),
		tpl = '<li style="background-image: url(' + mediaUrl + ')" title="' + item + '"></li>';

	if (!mediaUrl) {
		console.error(item + ' skipped');
		return;
	}
	// добавляем
	if (insertAfter) {
		getSortableWrapper(galleryBlock).append(tpl);
	}
	else {
		getSortableWrapper(galleryBlock).prepend(tpl);
	}

	refreshSortableWrapper(galleryBlock);
}

/**
 * вызывает ререндеринг сортируемого списка и реинициализацию виджета сортейбл
 *
 * @param galleryBlock
 */
function refreshSortableWrapper(galleryBlock) {
	// если запущено обновление
	if (globalTimerRefreshSortable) {
		clearTimeout(globalTimerRefreshSortable);
	}
	globalTimerRefreshSortable = setTimeout(function () {
		console.log('refrsh');
		getSortableWrapper(galleryBlock).sortable("refresh");
	}, 10);
}

/**
 * получить ссылку на картинку по ссылке в ютубе или из нашего аплоада
 *
 * @param mediaUrl
 * @returns {*}
 */
function getImageFromMediaUrl(mediaUrl) {
	// картинка с аплоада
	if (mediaUrl.indexOf('/upload/') === 0) {
		return mediaUrl;
	}
	// видео с ютуба
	if (mediaUrl.indexOf('youtu') >= 0) {
		var regsArr, myArray, videoHash;
		regsArr = [
			// подходит под патерн https://www.youtube.com/embed/-HA0nHDuq6Q
			/(?:\/embed\/|youtu\.be\/)([^\?^\"]+)/gi,
			// подходит под патерн https://www.youtube.com/watch<..............>v=-HA0nHDuq6Q
			/youtube\.com\/watch[\S]+v=([^&]+)/gi,
			// подходит под патерн https://youtu.be/-HA0nHDuq6Q
			/youtube\.com\/watch[\S]+v=([^&]+)/gi
		];

		regsArr.forEach(function (myRe, i, arr) {
			myArray = myRe.exec(mediaUrl);
			if (myArray) {
				videoHash = myArray[1];
			}
		});
		if (videoHash) {
			return '//img.youtube.com/vi/' + videoHash + '/mqdefault.jpg';
		}
	}

	return false;
}

/**
 * лишний раз проставляем всем строчкам состояние "выделено"
 *
 * @param activeformInput
 */
function selectAllOptionsInInputBlock(activeformInput) {
	activeformInput.find('option').prop('selected', true);
}


/*
 *  разные ключевые элементы
 */
function getSortableWrapper(galleryBlock) {
	return galleryBlock.find(".js_sortableWrapper");
}
function getActiveformInput(galleryBlock) {
	var inputId = galleryBlock.attr("data-input-id");
	return $('#' + inputId);
}
function getParentGalleryBlock(self) {
	return self.parents('.js_mixedGalleryBlock');
}
function getParenImageAddingWrapper(self) {
	return self.parents('.js_imageAddingWrapper');
}

/**
 *  call-back для выбора картинки из аплоада
 *
 * @param fieldId
 */
function MixedGalleryCallBack(fieldId) {
	if (fieldId) {
		var obj, url;
		obj = $('#' + fieldId);
		url = new URL(obj.val());
		obj.val(url.pathname);
		$('.fancybox-close').trigger('click');
	}
}

/**
 * в зависимости от наличия класса "selected" - показать или скрыть панель действий
 *
 * @param panelObj
 * @param sortableWrapper
 */
function showOrHideListActionsPanel(panelObj, sortableWrapper) {
	setTimeout(function () {
		sortableWrapper.find('.' + selectedClass).length ? panelObj.show() : panelObj.hide();
	}, 10);
}

var
	selectedClass = 'selected',
	selectorListActionsPanel = '.js_imageListActionsPanel',
	globalTimerRefreshSortable;

$(document)
	// клик на картинку
	.on('click', '.js_sortableWrapper li', function (e) {
		var self, panelObj, nowSelectedCnt, sortableWrapper, galleryBlock, fnDeselectAll, fnDeselectCurrent,
			fnToggleClass;
		self = $(this);
		galleryBlock = getParentGalleryBlock(self);
		panelObj = galleryBlock.find(selectorListActionsPanel);
		nowSelectedCnt = panelObj.find(selectedClass).length;
		sortableWrapper = getSortableWrapper(galleryBlock);
		fnDeselectAll = function () {
			sortableWrapper.find('li').removeClass(selectedClass);
		};
		fnDeselectCurrent = function () {
			self.removeClass(selectedClass);
		};
		fnToggleClass = function () {
			self.toggleClass(selectedClass);
		};

		// поведение при зажатом Ctrl
		if (e.ctrlKey) {
			// если нажат контрол - тоглим класс у текущего элемента
			fnToggleClass();
			showOrHideListActionsPanel(panelObj, sortableWrapper);
			return;
		}
		// Ctrl не зажат. единичное поведение
		else {
			// если выделена куча итемов или и отжали контрол - сбрасываем все выделения
			// если без контрола нажали на имеющий выделение
			if (nowSelectedCnt > 1 || self.hasClass(selectedClass)) {
				fnDeselectAll();
				showOrHideListActionsPanel(panelObj, sortableWrapper);
				return;
			}
			// выделяем на тот, который ткнули
			fnDeselectAll();
			self.addClass(selectedClass);
		}
		showOrHideListActionsPanel(panelObj, sortableWrapper);
	})
	// удалить выбранню фотку из списка
	.on('click', '.js_deleteFromList', function (e) {
		e.preventDefault();
		var self, galleryBlock, sortableWrapper, selectedElement;
		self = $(this);
		galleryBlock = getParentGalleryBlock(self);
		sortableWrapper = getSortableWrapper(galleryBlock);
		selectedElement = sortableWrapper.find('.' + selectedClass);
		galleryBlock.find(selectorListActionsPanel).hide();

		// если не нашли, что удалять надо
		if (!selectedElement.length) {
			console.log('nothing to delete');
			return false;
		}
		// удалили, обновили сортэйбл, выгрузили в инпут содержимое
		selectedElement.remove();
		setTimeout(function () {
			refreshSortableWrapper(galleryBlock);
			updateInputFromSortableList(galleryBlock);
		}, 1);
	})
	.on('click', '.js_addImage', function (e) {
		e.preventDefault();
		var self, addingUrl, galleryBlock, inputElement, parentImageAddingWrapper, insertAfter;
		self = $(this);
		galleryBlock = getParentGalleryBlock(self);
		parentImageAddingWrapper = getParenImageAddingWrapper(self);
		inputElement = parentImageAddingWrapper.find('.js_addingLinkInput');
		addingUrl = $.trim(inputElement.val());
		// если начинается с  http
		if (addingUrl.indexOf('http') === 0) {
			// должно содержать youtu
			if (addingUrl.indexOf('youtu') === -1) {
				console.log(addingUrl + ' not youtube link');
				return false;
			}
		}
		// иначе должно начинатся с /upload/
		else if (addingUrl.indexOf('/upload/') !== 0) {
			console.log(addingUrl + ' not file from upload');
			return false;
		}
		inputElement.val('');
		insertAfter = (self.attr('data-add-to') == 'top') ? false : true;
		//
		addNewItemToSortableWrapper(galleryBlock, addingUrl, insertAfter);
		updateInputFromSortableList(galleryBlock);
	})
;