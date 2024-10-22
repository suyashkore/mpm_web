let currentSlide = 0;
function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    if (index >= slides.length) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = slides.length - 1;
    } else {
        currentSlide = index;
    }
    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === currentSlide);
    });
}


// function nextSlide() {
//     showSlide(currentSlide + 1);
// }

// function for going on next slide after complition of current slide
function nextSlide() {
    const currentSlide = document.querySelector('.slide.active');
    const nextSlide = currentSlide.nextElementSibling; // Assuming slides are in order

    if (nextSlide) {
        currentSlide.classList.remove('active');
        nextSlide.classList.add('active');
    }
}


// function backSlide() {
//     showSlide(currentSlide - 1);
// }

// function for going on back slide
function backSlide() {
    const currentSlide = document.querySelector('.slide.active');
    const previousSlide = currentSlide.previousElementSibling; // Assuming slides are in order

    if (previousSlide) {
        currentSlide.classList.remove('active');
        previousSlide.classList.add('active');
    }
}


showSlide(currentSlide);

function validateFormFirstSlide() {
    var formElements = document.querySelectorAll('#slide1 input, #slide1 select');
    var isValid = true;
    var isSelect = true;

    for (var i = 0; i < formElements.length; i++) {
        if (!formElements[i].checkValidity()) {
            isValid = false;
            formElements[i].reportValidity();
            break;
        }
    }


    const selectElement1 = document.getElementById('projectStatus');
    if (selectElement1.value =="") {
        selectElement1.setCustomValidity('Please select a project status.');
        isSelect = false;
    } else {
        selectElement1.setCustomValidity('');
    }

    const selectElement2 = document.getElementById('clientTypeOption');
    if (selectElement2.value =="") {
        selectElement2.setCustomValidity('Please select a Client Type.');
        isSelect = false;
    } else {
        selectElement2.setCustomValidity('');
    }
    
    const selectElement3 = document.getElementById('selectClient');
    if (selectElement3.value =="") {
        selectElement3.setCustomValidity('Please select a Client.');
        isSelect = false;
    } else {
        selectElement3.setCustomValidity('');
    }
    

    if (isValid && isSelect) { 
            const slide1 = document.getElementById('slide1');
            const inputs = slide1.querySelectorAll('input, select');
            let values = {};

            inputs.forEach(input => {
                if (input.type === 'select-one') {
                    values[input.name] = input.options[input.selectedIndex].value;
                } else {
                    values[input.name] = input.value;
                }
            });
            let project_id = $('#project_id').val();
            // alert(project_id);
            values['project_id'] = project_id;
            // console.log(values);
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', './ajaxphp/push_into_temp_project_slide1.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
             let response = JSON.parse(xhr.responseText);
            //  console.log(response);
                if (xhr.status == 200) {
                    // alert(response.project_id);
                    $('#project_id').val(response.project_id);
                    nextSlide();
                } else {
                    console.error('Error fetching data: ' + xhr.status);
                }
            };
            var params = Object.keys(values).map(function(key) {
                return encodeURIComponent(key) + '=' + encodeURIComponent(values[key]);
            }).join('&');
            xhr.send(params);
    }
}

// function validateFormSecondSlide() {
//     var formElements = document.querySelectorAll('#slide1 input, #slide2 select');
//     var isValid = true;

//     formElements.forEach(function(element) {
//         if (!element.checkValidity()) {
//             isValid = false;
//             element.reportValidity();
//         }
//     });

//     if (isValid) {


//         const slide1 = document.getElementById('slide2');
//             const inputs = slide1.querySelectorAll('input, select');
//             let values = {};

//             inputs.forEach(input => {
//                 if (input.type === 'select-one') {
//                     values[input.name] = input.options[input.selectedIndex].value;
//                 } else {
//                     values[input.name] = input.value;
//                 }
//             });
//             let project_id = $('#project_id').val();
//             // alert(project_id);
//             values['project_id'] = project_id;
//             console.log(values);
            
//             var xhr = new XMLHttpRequest();
//             xhr.open('POST', './ajaxphp/push_into_temp_project_slide2.php', true);
//             xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
//             xhr.onload = function() {
//              let response = JSON.parse(xhr.responseText);
//              console.log(response);
//                 if (xhr.status == 200) {
//                     console.log(response);
//                     nextSlide();
//                 } else {
//                     console.error('Error fetching data: ' + xhr.status);
//                 }
//             };
//             var params = Object.keys(values).map(function(key) {
//                 return encodeURIComponent(key) + '=' + encodeURIComponent(values[key]);
//             }).join('&');
//             xhr.send(params);
//     }

//     }



// Validation for required fields on slide2

function validateFormSecondSlide() {
    const formElements = document.querySelectorAll('#slide2 input, #slide2 select');
    let isValid = true;

    // Validate required fields
    formElements.forEach(element => {
        if (element.required && !element.value) {
            isValid = false;
            element.classList.add('is-invalid');
            if (element.reportValidity) element.reportValidity();
        } else {
            element.classList.remove('is-invalid');
        }
    });

    // Validate required checkboxes
    const requiredCheckboxes = ['loa', 'contract', 'sd', 'pg'];
    let allChecked = requiredCheckboxes.every(id => document.getElementById(id).checked);

    requiredCheckboxes.forEach(id => {
        const checkbox = document.getElementById(id);
        if (!checkbox.checked) {
            checkbox.classList.add('is-invalid');
        } else {
            checkbox.classList.remove('is-invalid');
        }
    });

    if (!allChecked) {
        isValid = false;
        showMessage("Please check all required checkboxes.");
    }

    if (isValid) {
        const values = Array.from(formElements).reduce((acc, input) => {
            acc[input.name] = input.value || (input.selected ? input.value : '');
            return acc;
        }, {});

        values['project_id'] = document.getElementById('project_id').value;

        console.log(values); // Debug output

        // Send AJAX request
        sendAjaxRequest(values);
    }
}

function sendAjaxRequest(data) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/push_into_temp_project_slide2.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let response;
        try {
            response = JSON.parse(xhr.responseText);
        } catch (e) {
            console.error('Invalid JSON response:', xhr.responseText);
            return;
        }

        if (xhr.status == 200) {
            console.log(response);
            nextSlide(); // Only call nextSlide() after a successful response
        } else {
            console.error('Error fetching data: ' + xhr.status);
            showMessage("An error occurred while processing your request.");
        }
    };

    const params = new URLSearchParams(data).toString();
    xhr.send(params);
}

function showMessage(message) {
    // Implement a function to display messages in the UI
    alert(message); // Consider replacing with better UX (e.g., toast notification)
}



function validateFormThirdSlide() {
    // alert("test");
    var formElements = document.querySelectorAll('#slide1 input, #slide3 select');
    var isValid = true;

    formElements.forEach(function(element) {
        if (!element.checkValidity()) {
            isValid = false;
            element.reportValidity();
        }
    });

    if (isValid) {
        const slide1 = document.getElementById('slide3');
        const inputs = slide1.querySelectorAll('input, select');
        let values = {};

        inputs.forEach(input => {
            if (input.type === 'select-one') {
                values[input.name] = input.options[input.selectedIndex].value;
            } else {
                values[input.name] = input.value;
            }
        });
        let project_id = $('#project_id').val();
        // alert(project_id);
        values['project_id'] = project_id;
        console.log(values);
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './ajaxphp/push_into_temp_project_slide3.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
         let response = JSON.parse(xhr.responseText);
        //  console.log(response);
            if (xhr.status == 200) {
                console.log(response);
                nextSlide();
            } else {
                console.error('Error fetching data: ' + xhr.status);
            }
        };
        var params = Object.keys(values).map(function(key) {
            return encodeURIComponent(key) + '=' + encodeURIComponent(values[key]);
        }).join('&');
        xhr.send(params);

        nextSlide();
    }
}

function createProject() {
    alert("project submit");
    document.getElementById('initiateProject').submit();
}

// validation 

document.getElementById('projectName').addEventListener('input', function() {
    var projectName = document.getElementById('projectName').value;
    var errorMessage = document.getElementById('error-message');
    
    var regex = /^[A-Za-z]+(?: [A-Za-z]+)*$/;
    
    var trimmedProjectName = projectName.trim();
    
    if (!regex.test(trimmedProjectName) || projectName.includes('  ')) {
        errorMessage.style.display = 'inline';
        $('#next1').prop('disabled', true);
    } else {
        errorMessage.style.display = 'none';
        $('#next1').prop('disabled', false);
    }
});

document.getElementById('salesPersonName').addEventListener('input', function() {
    var salesPersonName = document.getElementById('salesPersonName').value;
    var errorMessage1 = document.getElementById('error-message1');
    
    var regex = /^[A-Za-z]+(?: [A-Za-z]+)*$/;
    
    var trimmedProjectName = salesPersonName.trim();
    
    if (!regex.test(trimmedProjectName) || salesPersonName.includes('  ')) {
        errorMessage1.style.display = 'inline';
        $('#next1').prop('disabled', true);
    } else {
        errorMessage1.style.display = 'none';
        $('#next1').prop('disabled', false);
    }
});


// mobile number validation

document.getElementById('salesPersonNo').addEventListener('input', function(e) {
    var value = e.target.value;
    var errorMessage = document.getElementById('error-message-mobile');
    
    if (value.length === 1 && !/[6-9]/.test(value)) {
        // alert("test2");
        e.target.value = '';
        errorMessage.style.display = 'block';
    } else if (value.length > 10) {
        e.target.value = value.slice(0, 10);
    } else {
        errorMessage.style.display = 'none';
    }
});

document.getElementById('salesPersonNo').addEventListener('keypress', function(e) {
    var char = String.fromCharCode(e.which);
    if (!/[0-9]/.test(char)) {
        e.preventDefault();
    }
});

document.getElementById('salesPersonNo').addEventListener('invalid', function() {
    var errorMessage = document.getElementById('error-message-mobile');
    errorMessage.style.display = 'block';
    // alert("test")
});

document.getElementById('salesPersonNo').addEventListener('blur', function() {
    var errorMessage = document.getElementById('error-message-mobile');
    if (this.checkValidity()) {
        errorMessage.style.display = 'none';
    }
});

// amount validation 
$(document).ready(function() {
    $('#revenueAmount').on('input', function() {
        let sanitizedValue = $(this).val().replace(/\D/g, '');
        $(this).val(sanitizedValue);
    });
});


// profit loss

const amountForIt = () => {
    let selectedValue = document.querySelector('input[name="profitLoss"]:checked').value;

    if (selectedValue === 'profit') {
        document.getElementById('pamt').style.display = '';
        document.getElementById('lamt').style.display = 'none';
    } else if (selectedValue === 'loss') {
        document.getElementById('pamt').style.display = 'none';
        document.getElementById('lamt').style.display = '';
    }
}

// add department row 
// const addDepartment = () => {
//     let newRow = document.createElement('div');
//     newRow.className = 'row mb-3'; 

//     let col1 = document.createElement('div');
//     col1.className = 'col-12 col-md-4 addmargin';
//     let input1 = document.createElement('input');
//     input1.type = 'text';
//     input1.className = 'form-control';
//     input1.name = 'department_name[]'; 
//     input1.placeholder = 'Department Name';
//     col1.appendChild(input1);

//     let col2 = document.createElement('div');
//     col2.className = 'col-12 col-md-4 addmargin';
//     let input2 = document.createElement('input');
//     input2.type = 'text';
//     input2.className = 'form-control';
//     input2.name = 'department_head[]'; 
//     input2.placeholder = 'Department Head';
//     col2.appendChild(input2);


//     let col3 = document.createElement('div');
//     col3.className = 'col-12 col-md-4';
//     let removeButton = document.createElement('button');
//     removeButton.type = 'button';
//     removeButton.className = 'btn btn-danger';
//     // removeButton.textContent = 'Remove';
//     removeButton.textContent = '-';
//     removeButton.style.fontSize = '18px'; 
//     removeButton.style.border = ''; 
//     removeButton.style.color = 'black';
//     removeButton.style.backgroundColor = 'transparent';
//     removeButton.onclick = function() {
//         newRow.remove();
//     };
//     col3.appendChild(removeButton);

//     newRow.appendChild(col1);
//     newRow.appendChild(col2);
//     newRow.appendChild(col3);

//     document.getElementById('departmentContainer').appendChild(newRow); 
// }

const addDepartment = () => {

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/get_department.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
     let response = JSON.parse(xhr.responseText);
    //  console.log(response);
        if (xhr.status == 200) {
            console.log(response);
            let departments =[];
            let departmentid =[];
            (response.department).forEach(dname => {
                // console.log(dname.dept_name)
                departments.push(dname.dept_name); 
                departmentid.push(dname.dept_id); 
            });
                // console.log(departments)
            
            let newRow = document.createElement('div');
    newRow.className = 'row mb-3'; 

    // Column 1: Department Name (Select box)
    let col1 = document.createElement('div');
    col1.className = 'col-12 col-md-4 addmargin';
    let select1 = document.createElement('select');
    select1.className = 'form-select';
    select1.name = 'department_name[]'; 

    // Add options to the department name select box
    // let departments = ['HR', 'Finance', 'IT', 'Marketing'];
    departments.forEach((dept, index) => {
        let option = document.createElement('option');
        option.value = departmentid[index];
        option.textContent = dept;
        select1.appendChild(option);
    });

    col1.appendChild(select1);

    // Column 2: Department Head (Select box)
    let col2 = document.createElement('div');
    col2.className = 'col-12 col-md-4 addmargin';
    let select2 = document.createElement('select');
    select2.className = 'form-select';
    select2.name = 'dep_hod[]'; 

    // Add options to the department head select box
    let departmentHeads = ['Sanket', 'Aadesh', 'Sandhya', 'Aashish'];
    let departmentHeadsId = ['EMP-00001', 'EMP-00002', 'EMP-00003', 'EMP-00004'];
    departmentHeads.forEach((head,index) => {
        let option = document.createElement('option');
        option.value = departmentHeadsId[index];
        option.textContent = head;
        select2.appendChild(option);
    });

    col2.appendChild(select2);

    // Column 3: Remove button
    let col3 = document.createElement('div');
    col3.className = 'col-12 col-md-4';
    let removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = '-';
    removeButton.style.fontSize = '18px'; 
    removeButton.style.border = ''; 
    removeButton.style.color = 'black';
    removeButton.style.backgroundColor = 'transparent';
    removeButton.onclick = function() {
        newRow.remove();
    };
    col3.appendChild(removeButton);

    newRow.appendChild(col1);
    newRow.appendChild(col2);
    newRow.appendChild(col3);

    document.getElementById('departmentContainer').appendChild(newRow); 


        } else {
            console.error('Error fetching data: ' + xhr.status);
        }
    };
   
    xhr.send();




    
}


// get client 
 function getClient() {
   let client_type_id = $('#clientTypeOption').val();
   var xhr = new XMLHttpRequest();
   xhr.open('POST', './ajaxphp/get_clients.php', true);
   xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
   xhr.onload = function() {
    let response = JSON.parse(xhr.responseText);
       if (xhr.status == 200) {
           console.log(response);
           let optionsHtml = '';
           if(response.msg == 'Get all client'){
            document.getElementById('selectClient').innerHTML ="";   
            document.getElementById('client_type_id_01').value = response.client_type_id;   
            
            optionsHtml += `<option selected">Choose...</option>`;
            response.client.forEach(client => {
                optionsHtml += `<option value="${client.client_id}">${client.name_of_official}</option>`;
            });
           } else {
            document.getElementById('selectClient').innerHTML ="";   
            document.getElementById('client_type_id_01').value = response.client_type_id; 
            optionsHtml += `<option selected">Choose...</option>`;
           }
          
           document.getElementById('selectClient').innerHTML = optionsHtml;
       } else {
           console.error('Error fetching data: ' + xhr.status);
       }
   };
   var params = 'client_type_id=' + encodeURIComponent(client_type_id);

   xhr.send(params);
 }

 // get client with default select

 function getClient(client_id) {
    let client_type_id = $('#clientTypeOption').val(); // Get the selected client type ID

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/get_clients.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status == 200) {
            let response = JSON.parse(xhr.responseText);
            let optionsHtml = '';
            if (response.msg == 'Get all client') {
                document.getElementById('selectClient').innerHTML = "";
                document.getElementById('client_type_id_01').value = response.client_type_id;
                optionsHtml += `<option selected disabled>Choose...</option>`;
                response.client.forEach(client => {
                    let selected = (client.client_id == client_id) ? 'selected' : '';
                    optionsHtml += `<option value="${client.client_id}" ${selected}>${client.name_of_official}</option>`;
                });
            } else {
                document.getElementById('selectClient').innerHTML = "";
                document.getElementById('client_type_id_01').value = response.client_type_id;
                optionsHtml += `<option selected disabled>Choose...</option>`;
            }
            document.getElementById('selectClient').innerHTML = optionsHtml;
        } else {
            console.error('Error fetching data: ' + xhr.status);
        }
    };

    var params = 'client_type_id=' + encodeURIComponent(client_type_id);
    xhr.send(params);
}


//  create new client 

function createNewClient() {

    let selectedClient = $('#clientTypeOption').val();
    if (selectedClient !== "Choose..." && selectedClient != "") {
        var modal = document.getElementById("createNewClient");
        modal.style.display = "block";
    } else {
        var modal = document.getElementById("client_type_not_select");
        modal.style.display = "block";
    }
   
}

function cancelTypeNotSelect() {
    var modal = document.getElementById("client_type_not_select");
    modal.style.display = "none";
}

function cancel() {
    var modal = document.getElementById("createNewClient");
    modal.style.display = "none";
}   

// edit client details

function editClientDetails() {

    let selectedClient = $('#selectClient').val();
    if (selectedClient !== "Choose...") {
        console.log("Client selected: " + selectedClient);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './ajaxphp/get_client_details.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
         let response = JSON.parse(xhr.responseText);
            if (xhr.status == 200) {
                // console.log(response);
                let clientDetails = response.client_details;
                console.log(clientDetails);
                if(response.msg == 'Get client details'){
                    $('#offcerIncharge_edit').val(clientDetails.name_of_official);
                    $('#designationOfClientEdit').val(clientDetails.client_designation);
                    $('#officeOsdNameEdit').val(clientDetails.OSD_name);
                    $('#officeOsdNumberEdit').val(clientDetails.OSD_contact_no);
                    $('#officeOsdEmailEdit').val(clientDetails.OSD_email_id);
                    $('#officeAddressEdit').val(clientDetails.client_address);
                    $('#officialCommunicationEmailIdEdit').val(clientDetails.official_email_id);
                    $('#mobileNumberEdit').val(clientDetails.official_contact_no);
                } else {
                 
                }
               
            } else {
                console.error('Error fetching data: ' + xhr.status);
            }
        };
        var params = 'client_id=' + encodeURIComponent(selectedClient);
     
        xhr.send(params);


    var modal = document.getElementById("editClientDetails");
    modal.style.display = "block";


    } else {
        var modal = document.getElementById("client_not_select");
        modal.style.display = "block";
    }    
}
function cancelNotSelect() {
    var modal = document.getElementById("client_not_select");
    modal.style.display = "none";
}

function successAdd() {
    var modal = document.getElementById("success_add");
    modal.style.display = "none";
}
function editCancel() {
    var modal = document.getElementById("editClientDetails");
    modal.style.display = "none";
}


// project value validation 

    $(document).ready(function() {
        $('#loa').change(function() {
            if ($(this).is(':checked')) {
                $('.loaamount').css('display', 'inline');
            } else {
                $('.loaamount').css('display', 'none');
            }
        });
        $('#sd').change(function() {
            if ($(this).is(':checked')) {
                $('.sd').css('display', 'inline');
            } else {
                $('.sd').css('display', 'none');
            }
        });
        $('#pg').change(function() {
            if ($(this).is(':checked')) {
                $('.pg').css('display', 'inline');
            } else {
                $('.pg').css('display', 'none');
            }
        });
        $('#bg').change(function() {
            if ($(this).is(':checked')) {
                $('.bg').css('display', 'inline');
            } else {
                $('.bg').css('display', 'none');
            }
        });
        $('#emd').change(function() {
            if ($(this).is(':checked')) {
                $('.emd').css('display', 'inline');
            } else {
                $('.emd').css('display', 'none');
            }
        });
    });

    // for last sidebar project initiation tab 

    function checkLastProject_01(){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './ajaxphp/chech_temp_project.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            let response = JSON.parse(xhr.responseText);
            if (xhr.status == 200) {
                if(response.msg == 'project found'){
                    // window.location.href = "./project_initiation.php";
                    $('#decideProject').css('display', 'block');
                } else {
                    window.location.href = "./project_initiation.php";
                }
            } else {
                console.error('Error fetching data: ' + xhr.status);
            }
        };
    
        xhr.send();
    }

    function closeModal(){
        $('#decideProject').css('display', 'none');
    }

    // project initiation 

    function continueEditing() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './ajaxphp/get_data_temp_project.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            let response = JSON.parse(xhr.responseText);
            if (xhr.status == 200) {
            //    console.log(response);
               window.location.href = "./continue_project_initiation.php";
               $('#decideProject').css('display', 'none');  
            } else {
                console.error('Error fetching data: ' + xhr.status);
            }
        };
    
        xhr.send();
    }
    function initiateNew() {

        var xhr = new XMLHttpRequest();
        xhr.open('POST', './ajaxphp/remove_data_temp_project.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            let response = JSON.parse(xhr.responseText);
            if (xhr.status == 200) {
               console.log(response); 
               window.location.href = "./project_initiation.php";
            } else {
                console.error('Error fetching data: ' + xhr.status);
            }
        };
    
        xhr.send();


       
    }

    // project complition date 

    function getDate() {

        let months = parseInt($('#projectComplitionTime').val());
   
        if (!isNaN(months) && months > 0) {
            let currentDate = new Date();
            currentDate.setMonth(currentDate.getMonth() + months);

            let completionDate = currentDate.toLocaleDateString('en-GB');
            $('#complition_date').text(completionDate);
            $('#complition_date').css('display', '');
            $('#complition_label').css('display', '');
        } else {
            $('#complition_date').text('');
        }
    }
    

    // billing milestone 
    // create new client 

    const createNewClientForProject = () => {
        const form = document.getElementById('create_new_client_form');
    
        const formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './ajaxphp/create_new_client.php', true);
    
        xhr.onload = function() {
            if (xhr.status == 200) {
                let response = JSON.parse(xhr.responseText);
                console.log(response);
                if(response.msg == "client created") {
                    var modal = document.getElementById("createNewClient");
                    modal.style.display = "none";
                    getClient(response.client_id);


                }

            } else {
                console.error('Error fetching data: ' + xhr.status);
            }
        };

        xhr.send(formData);
    }
    
    // get selected manager 
    const getSelectedManager = () => {
        // var selectedManager = $('#projectManager').val();
        var selectedManager = $('#projectManager option:selected').text().trimStart();
        $('#projectManager_assign').val(selectedManager);
    }
    