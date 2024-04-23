function remove(uuid) {
	toggleModal("removeModal")
	document.getElementById("removeInput").setAttribute("value", uuid)
}

function toggleModal(id) {
	document.getElementById(id).classList.toggle("hidden");
}