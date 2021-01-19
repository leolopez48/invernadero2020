const url = 'http://localhost:8000/api/stations/';
const urlBase = 'http://localhost:8000/';
// const url = 'http://192.168.1.21/api/stations/';
// const urlBase = 'http://192.168.1.21/';
export default class Libs {


    removeChilds(myNode) {
        while (myNode.firstChild) {
            myNode.removeChild(myNode.lastChild);
        }
    }

    closeLoader() {
        document.getElementById('loader').style.display = 'none';
        document.getElementById('loader-toggle').classList.remove('active');
    }

    openLoader() {
        document.getElementById('loader-toggle').classList.add('active');
    }

    loadPreview(ev) {
        let preview = document.getElementById('inPhotoPre');
        let file = document.getElementById('inFile');
        preview.src = URL.createObjectURL(ev.target.files[0]);
        preview.onload = function () {
            URL.revokeObjectURL(preview.src) // free memory
        }
    }

    message(title, message, icon) {
        Swal.fire(
            title,
            message,
            icon
        );
    }

    resetForm() {
        document.getElementById('btnTypeInv').style.display = 'initial';
        document.getElementById('btnTypeAcu').style.display = 'initial';
        document.getElementById('inPhotoPre').src = `${urlBase}default/no-image.png`;
        document.getElementById('inPhotoPre').value = "";

        document.getElementById('inFile').value = "";
        document.getElementById('inName').value = "";
        document.getElementById('inDescription').value = "";

        document.getElementById('inLowestPH').value = "";
        document.getElementById('inLowestPT').value = "";
        document.getElementById('inLowestPR').value = "";
        document.getElementById('inHighestPH').value = "";
        document.getElementById('inHighestPT').value = "";
        document.getElementById('inHighestPR').value = "";
        document.getElementById('divInputsLow').style.display = 'none';
        document.getElementById('divVar').style.display = 'none';
        const users = document.getElementById('divUserAllowed');
        this.removeChilds(users);
        document.getElementById('divSearch').style.display = 'none';
    }

    hideByAccess() {
        document.getElementById('btnNewDiv').style.display = 'none';
    }

    cleanDivStations() {
        const divStations = document.getElementById('divStations');
        this.removeChilds(divStations);
    }

    hideInputs(input) {
        input.style.display === 'initial' ? input.style.display = 'none' : input.style.display = 'initial';
    }

    hideInputsBoolean(boolean) {
        if (boolean) {
            document.getElementById('divLowTemp').style.display = 'none';
            document.getElementById('divLowHum').style.display = 'none';
            document.getElementById('divLowRad').style.display = 'none';
            document.getElementById('divHighTemp').style.display = 'none';
            document.getElementById('divHighHum').style.display = 'none';
            document.getElementById('divHighRad').style.display = 'none';
            document.getElementById('divLowPHL').style.display = 'none';
            document.getElementById('divLowOx').style.display = 'none';
            document.getElementById('divHighPHL').style.display = 'none';
            document.getElementById('divHighOx').style.display = 'none';
        } else {
            document.getElementById('divLowTemp').style.display = 'initial';
            document.getElementById('divLowHum').style.display = 'initial';
            document.getElementById('divLowRad').style.display = 'initial';
            document.getElementById('divHighTemp').style.display = 'initial';
            document.getElementById('divHighHum').style.display = 'initial';
            document.getElementById('divHighRad').style.display = 'initial';
            document.getElementById('divLowPHL').style.display = 'initial';
            document.getElementById('divLowOx').style.display = 'initial';
            document.getElementById('divHighPHL').style.display = 'initial';
            document.getElementById('divHighOx').style.display = 'initial';
        }
    }

}
