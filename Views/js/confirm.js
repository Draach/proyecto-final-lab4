function confirm(self) {
    var id = self.getAttribute("data-id");
    document.getElementById("form-confirm").id.value = id;
    document.getElementById("form-confirm").action = self.getAttribute("data-action");
    if (self.getAttribute("data-message") != null) {
        document.getElementById("confirmMessage").innerHTML = self.getAttribute("data-message");
    }

    console.log(self.getAttribute("data-position"));

    if (self.getAttribute("data-position") != null) {
        var position = self.getAttribute("data-position");
        document.getElementById("position").innerHTML = position;
    }

    $("#confirmModal").modal("show");
}
