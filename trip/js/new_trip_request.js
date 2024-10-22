document.addEventListener("DOMContentLoaded", function () {
  // Get current date in yyyy-mm-dd format
  const today = new Date().toISOString().split("T")[0];

  // Set minimum and default value for 'Date' in 'For Hours' section
  document.getElementById("projectStratDate").setAttribute("min", today);
  document.getElementById("projectStratDate").setAttribute("value", today);

  // Set minimum and default value for 'Start Date' in 'For Multiple Days' section
  document.getElementById("startDateMultipleDays").setAttribute("min", today);
  document.getElementById("startDateMultipleDays").setAttribute("value", today);

  // Set minimum value for 'End Date' in 'For Multiple Days' section
  document.getElementById("endDateMultipleDays").setAttribute("min", today);
});
document.addEventListener("DOMContentLoaded", function () {
  // Initialize with one team member input by default
  generateTeamMemberInputs(1);

  // Handle duration selection change
  document.getElementById("duration").addEventListener("change", function () {
    toggleDurationFields(this.value);
  });

  // Add dynamic fields for each day between start and end dates for Multiple Days
  document
    .getElementById("endDateMultipleDays")
    .addEventListener("change", function () {
      generateMultipleDaysFields();
    });

  document
    .getElementById("startDateMultipleDays")
    .addEventListener("change", function () {
      generateMultipleDaysFields();
    });
});

document.getElementById("teamMembers").addEventListener("input", function () {
  const teamMembersCount = parseInt(this.value);
  generateTeamMemberInputs(teamMembersCount);
});

function generateTeamMemberInputs(count) {
  const container = document.getElementById("teamMembersContainer");
  container.innerHTML = ""; // Clear existing inputs

  for (let i = 0; i < count; i++) {
    const teamMemberDiv = document.createElement("div");
    teamMemberDiv.classList.add("form-group");
    teamMemberDiv.style.display = "flex";
    teamMemberDiv.style.alignItems = "center";
    teamMemberDiv.style.gap = "10px";

    teamMemberDiv.innerHTML = `
            <input type="text" name="team_member_name[]" placeholder="Name" class="form-control" style="width: 200px;" required>
            <input type="number" name="team_member_mobile[]" placeholder="Mobile number" class="form-control" style="width: 190px;" required>
            <label style="display: flex; align-items: center; gap: 5px;">
                <input type="checkbox" name="Leader" style="width: 14px;"> Leader
            </label>
        `;
    container.appendChild(teamMemberDiv);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Handle duration selection change
  document.getElementById("duration").addEventListener("change", function () {
    toggleDurationFields(this.value);
  });

  // Handle Multiple Days date selection change
  document
    .getElementById("startDateMultipleDays")
    .addEventListener("change", generateMultipleDaysFields);
  document
    .getElementById("endDateMultipleDays")
    .addEventListener("change", generateMultipleDaysFields);
});

function toggleDurationFields(duration) {
  const forHoursSection = document.getElementById("forHours");
  const forMultipleDaysSection = document.getElementById("forMultipleDays");

  if (duration === "Hours") {
    forHoursSection.classList.remove("hidden");
    forMultipleDaysSection.classList.add("hidden");
  } else if (duration === "Multiple Days") {
    forMultipleDaysSection.classList.remove("hidden");
    forHoursSection.classList.add("hidden");
  } else {
    forHoursSection.classList.add("hidden");
    forMultipleDaysSection.classList.add("hidden");
  }
}

function generateMultipleDaysFields() {
  const startDate = document.getElementById("startDateMultipleDays").value;
  const endDate = document.getElementById("endDateMultipleDays").value;
  const container = document.getElementById("multipleDaysFields");
  container.innerHTML = ""; // Clear previous fields

  if (startDate && endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);

    if (start > end) {
      alert("Start date cannot be after the end date.");
      return;
    }

    let dayCount = 0;
    for (let d = start; d <= end; d.setDate(d.getDate() + 1)) {
      dayCount++;

      const dayDiv = document.createElement("div");
      dayDiv.classList.add("day-section");
      dayDiv.style.marginBottom = "15px";

      const dateFormatted = d.toISOString().slice(0, 10); // Format as yyyy-mm-dd

      dayDiv.innerHTML = `
                <h4>Day ${dayCount} (${dateFormatted})</h4>
                <div class="form-group">
                    <label for="vehicles${dayCount}">No. of Vehicles Required</label>
                    <input type="number" name="vehicles[day${dayCount}]"  id="vehicles${dayCount}" min="1" class="form-control"  >
                </div>
                <div class="form-group time-group">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <div>
                            <label for="startTime${dayCount}">Start Time</label>
                            <input type="time"   name="startTime${dayCount}" id="startTime${dayCount}"  class="form-control" >
                        </div>
                        <div>
                            <label for="endTime${dayCount}">End Time</label>
                            <input type="time" name="endTime${dayCount}" id="endTime${dayCount}"  class="form-control" >
                        </div>
             
                        <div>
                             <label for="city${dayCount}">City</label>
                    <input type="text"  name="city${dayCount}" id="city${dayCount}" class="form-control"  >
                        </div>
                        <div>
                         <label for="location${dayCount}">Location</label>
                    <input type="text" name="location${dayCount}" id="location${dayCount}"  class="form-control" >
                        </div>
                    </div>
                </div>
            `;
      container.appendChild(dayDiv);
    }
  }
}
let currentPage = 1;
const recordsPerPage = 5; // Adjust the number of records per page

// Close the popup when clicking outside of it
window.addEventListener("click", function (event) {
  const popup = document.getElementById("popupForm");
  const openButton = document.getElementById("openPopup");
  // Check if the click was outside the popup and the button
  if (
    event.target === popup ||
    (!popup.contains(event.target) && event.target !== openButton)
  ) {
    popup.style.display = "none";
  }
});
