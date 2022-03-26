
// Get the which edit button is clicked
edits = document.getElementsByClassName('edit');
Array.from(edits).forEach((element) => {
    element.addEventListener("click", (e) => {
        // console.log("edit ", );

        tr = e.target.parentNode.parentNode;
        // cid = tr.getElementsByTagName('td')[0].innerText;
        let name = tr.getElementsByTagName('td')[1].innerText;
        let website = tr.getElementsByTagName('td')[2].innerText;
        let phone = tr.getElementsByTagName('td')[3].innerText;
        let address = tr.getElementsByTagName('td')[4].innerText;
        let city = tr.getElementsByTagName('td')[5].innerText;
        let state = tr.getElementsByTagName('td')[6].innerText;
        let country = tr.getElementsByTagName('td')[7].innerText;
        let industry_list = tr.getElementsByTagName('td')[8].innerText;


        // cidEdit.value = cid;
        nameEdit.value = name;
        websiteEdit.value = website;
        phoneEdit.value = phone;
        addressEdit.value = address;
        cityEdit.value = city;
        stateEdit.value = state;
        countryEdit.value = country;
        industry_listEdit.value = industry_list;
        srnoEdit.value = e.target.id;

        console.log(srnoEdit.value);

        $('#editModal').modal('toggle');
    })
})

// Get which element user wants to delete
deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach((element) => {
    element.addEventListener("click", (e) => {
        console.log("delete ");
        srno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this Record!")) {
            window.location = `/loginsystem/welcome.php?delete=${srno}`;
            // TODO: Create a form and use post request to submit a form
        } else {
            
        }
    })
})