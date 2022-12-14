(self["webpackChunk"] = self["webpackChunk"] || []).push([["/assets/js/coreui/media"],{

/***/ "./resources/js/coreui/media.js":
/*!**************************************!*\
  !*** ./resources/js/coreui/media.js ***!
  \**************************************/
/***/ (function() {

var self = this;
this.removeFolderModal = new coreui.Modal(document.getElementById('remove-folder-modal'));
this.removeFileModal = new coreui.Modal(document.getElementById('remove-file-modal'));

this.showCard = function (showThisCard) {
  document.getElementById('file-rename-file-card').classList.add('d-none');
  document.getElementById('file-info-card').classList.add('d-none');
  document.getElementById('file-rename-folder-card').classList.add('d-none');
  document.getElementById('file-move-file').classList.add('d-none');
  document.getElementById('file-move-folder').classList.add('d-none');
  document.getElementById(showThisCard).classList.remove('d-none');
};

this.buildFileInfoCard = function (data) {
  document.getElementById("file-div-name").innerText = data['name'];
  document.getElementById("file-div-real-name").innerText = data['realName'];
  document.getElementById("file-div-url").innerText = data['url'];
  document.getElementById("file-div-mime-type").innerText = data['mimeType'];
  document.getElementById("file-div-size").innerText = data['size'];
  document.getElementById("file-div-created-at").innerText = data['createdAt'];
  document.getElementById("file-div-updated-at").innerText = data['updatedAt'];
};

this.buildFileRenameFileCard = function (data) {
  document.getElementById("file-rename-file-id").value = data['id'];
  document.getElementById("file-rename-file-name").value = data['name'];
};

this.buildFileRenameFolderCard = function (data) {
  document.getElementById("file-rename-folder-id").value = data['id'];
  document.getElementById("file-rename-folder-name").value = data['name'];
};

this.clickFile = function (e) {
  axios.get('/media/file?id=' + e.target.getAttribute("atr") + '&thisFolder=' + document.getElementById('this-folder-id').value).then(function (response) {
    self.buildFileInfoCard(response.data);
    self.showCard('file-info-card');
  })["catch"](function (error) {
    console.log(error);
  });
};

this.fileChangeName = function (e) {
  axios.get('/media/file?id=' + e.target.getAttribute("atr") + '&thisFolder=' + document.getElementById('this-folder-id').value).then(function (response) {
    self.buildFileInfoCard(response.data); //must be

    self.buildFileRenameFileCard(response.data);
    self.showCard('file-rename-file-card');
  })["catch"](function (error) {
    console.log(error);
  });
};

this.folderChangeName = function (e) {
  axios.get('/media/folder?id=' + e.target.getAttribute("atr")).then(function (response) {
    self.buildFileRenameFolderCard(response.data);
    self.showCard('file-rename-folder-card');
  })["catch"](function (error) {
    console.log(error);
  });
};

this.moveFile = function (e) {
  document.getElementById('file-move-file-id').value = e.target.getAttribute('atr');
  self.showCard('file-move-file');
};

this.moveFolder = function (e) {
  document.getElementById('file-move-folder-id').value = e.target.getAttribute('atr');
  var radios = document.getElementsByClassName('file-move-folder-radio');

  for (var i = 0; i < radios.length; i++) {
    if (radios[i].value === e.target.getAttribute('atr')) {
      radios[i].disabled = true;
    } else {
      radios[i].disabled = false;
    }
  }

  self.showCard('file-move-folder');
};

this.deleteFolder = function (e) {
  document.getElementById('file-delete-folder-id').value = e.target.getAttribute('atr');
  self.removeFolderModal.show();
};

this.deleteFile = function (e) {
  document.getElementById('file-delete-file-id').value = e.target.getAttribute('atr');
  self.removeFileModal.show();
};

this.renameFileCancel = function () {
  self.showCard('file-info-card');
};

this.renameFolderCancel = function () {
  self.showCard('file-info-card');
};

this.moveFileCancel = function () {
  self.showCard('file-info-card');
};

this.moveFolderCancel = function () {
  self.showCard('file-info-card');
};

var files = document.getElementsByClassName("click-file");

for (var i = 0; i < files.length; i++) {
  files[i].addEventListener('click', this.clickFile);
}

var renameButtons = document.getElementsByClassName('file-change-file-name');

for (var _i = 0; _i < renameButtons.length; _i++) {
  renameButtons[_i].addEventListener('click', this.fileChangeName);
}

renameButtons = document.getElementsByClassName('file-change-folder-name');

for (var _i2 = 0; _i2 < renameButtons.length; _i2++) {
  renameButtons[_i2].addEventListener('click', this.folderChangeName);
}

var moveButtons = document.getElementsByClassName('file-move-file');

for (var _i3 = 0; _i3 < moveButtons.length; _i3++) {
  moveButtons[_i3].addEventListener('click', this.moveFile);
}

moveButtons = document.getElementsByClassName('file-move-folder');

for (var _i4 = 0; _i4 < moveButtons.length; _i4++) {
  moveButtons[_i4].addEventListener('click', this.moveFolder);
}

var deleteButtons = document.getElementsByClassName('file-delete-folder');

for (var _i5 = 0; _i5 < deleteButtons.length; _i5++) {
  deleteButtons[_i5].addEventListener('click', this.deleteFolder);
}

deleteButtons = document.getElementsByClassName('file-delete-file');

for (var _i6 = 0; _i6 < deleteButtons.length; _i6++) {
  deleteButtons[_i6].addEventListener('click', this.deleteFile);
}

document.getElementById('file-rename-file-cancel').addEventListener('click', this.renameFileCancel);
document.getElementById('file-rename-folder-cancel').addEventListener('click', this.renameFolderCancel);
document.getElementById('file-move-file-cancel').addEventListener('click', this.moveFileCancel);
document.getElementById('file-move-folder-cancel').addEventListener('click', this.moveFolderCancel);

document.getElementById('file-file-input').onchange = function () {
  document.getElementById('file-file-form').submit();
};

self.showCard('file-info-card');

/***/ })

},
0,[["./resources/js/coreui/media.js","/assets/js/coreui/manifest"]]]);