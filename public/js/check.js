var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".svg", ".png"];
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
        if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }

            if (!blnValid) {
                toastr.error('Неверный тип файла! Убедитесь, что ваш файл - изображение (jpg, jpeg, svg, bmp, png)') //popup error
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}
