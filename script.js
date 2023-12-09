document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.querySelector('.menu-btn');
    const menu = document.querySelector('.menu');

    menuBtn.addEventListener('click', function () {
        if (menu.style.width === '250px') {
            menu.style.width = '0';
        } else {
            menu.style.width = '250px';
        }
    });
});
function expandNote() {
    var noteTitle = document.getElementById("noteTitle");
    var noteContent = document.getElementById("noteContent");
    var saveButton = document.getElementsByName("save_note")[0];
    // Hide the original "Take a note..." field
    var originalNote = document.getElementById("noteContent");
    originalNote.style.display = "none";
    // Show the title input, content input, and button
    noteTitle.style.display = "block";
    noteContent.style.display = "block";
    saveButton.style.display = "block";

    noteContent.focus();
}
document.addEventListener("DOMContentLoaded", function () {
    var note = document.getElementById("myForm");

    if (note) {
        document.addEventListener("click", function (event) {
            var noteTitle = document.getElementById("noteTitle");
            var noteContent = document.getElementById("noteContent");
            var saveButton = document.getElementsByName("save_note")[0];
            var originalNote = document.getElementById("noteContent");
            // Check if the click occurred outside the note container
            var isOutsideNoteContainer = !event.target.closest("#myForm");
            if (isOutsideNoteContainer) {
                // Clicked outside the note container, hide the expanded view
                noteTitle.style.display = "none";
                noteContent.style.display = "none";
                saveButton.style.display = "none";
                originalNote.style.display = "block";
            }
        });
    } else {

    }
});
document.addEventListener('click', function (event) {
    const expandedNote = document.querySelector('.expanded-note');
    const isExpandedNoteClicked = expandedNote.contains(event.target);
    const isNoteListClicked = event.target.closest('.edited');

    if (!isExpandedNoteClicked && !isNoteListClicked) {
        expandedNote.style.display = 'none';
    }
});

// edit note
function expandShowNote(noteElement) {
    const expandedNote = document.querySelector('.expanded-note');
    const expandedTitle = document.getElementById('expandedTitle');
    const expandedContent = document.getElementById('expandedContent');
    const noteId = noteElement.getAttribute('data-note-id');
    // Set the content and title of the expanded note
    expandedTitle.textContent = noteElement.querySelector('h2').textContent;
    expandedContent.textContent = noteElement.querySelector('.note-content').textContent.trim();
    // Check if the note is in edit mode
    const isEditing = noteElement.classList.contains('editing');

    if (!isEditing) {
        // Enter edit mode
        noteElement.classList.add('editing');
        // Create input fields for editing
        expandedTitle.innerHTML = '<input type="text" id="editTitle" value="' + expandedTitle.textContent + '">';
        expandedContent.innerHTML = '<textarea id="editContent">' + expandedContent.textContent + '</textarea>';

        if (!expandedNote.querySelector('button')) {
            expandedNote.innerHTML += '<button onclick="saveEdit(' + noteId + ')">Edit</button>';
        }
    } else {
        // Exit edit mode
        noteElement.classList.remove('editing');

        // Get the edited content
        const editTitle = document.getElementById('editTitle').value;
        const editContent = document.getElementById('editContent').value;

        // Update the content
        expandedTitle.textContent = editTitle;
        expandedContent.textContent = editContent;

        // Remove the input fields and "Save" button
        document.getElementById('editTitle').remove();
        document.getElementById('editContent').remove();
        expandedNote.querySelector('button').remove();
    }

    // Show the expanded note
    expandedNote.style.display = 'block';
}

function saveEdit(noteId) {
    // console.log('Note ID:', noteId);
    const expandedNote = document.querySelector('.expanded-note');
    const expandedTitle = document.getElementById('expandedTitle');
    const expandedContent = document.getElementById('expandedContent');
    // Get the edited content
    const editTitle = document.getElementById('editTitle').value;
    const editContent = document.getElementById('editContent').value;

    // FormData object to send data via AJAX
    const formData = new FormData();
    formData.append('note_id', noteId);
    formData.append('new_title', editTitle);
    formData.append('new_content', editContent);

    // Send an AJAX request to update the note on the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'edit_note.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response if needed
            console.log(xhr.responseText);
            // Hide the expanded note
            expandedNote.style.display = 'none';
            location.reload();
        }
    };
    xhr.send(formData);

    // Exit edit mode
    // document.querySelector('.note.editing').classList.remove('editing');

    // Remove the "Save" button
    // document.querySelector('.expanded-note button').remove();

    // Show the expanded note
    // document.querySelector('.expanded-note').style.display = 'block';
}
document.getElementById('searchInput').addEventListener('input', function () {
    var searchQuery = this.value.toLowerCase();
    var notes = document.querySelectorAll('.note');
    var noResultsMessage = document.getElementById('noResultsMessage');

    var hasResults = false;

    notes.forEach(function (note) {
        var title = note.querySelector('h2').innerText.toLowerCase();
        var content = note.querySelector('.note-content').innerText.toLowerCase();
        var shouldShow = title.includes(searchQuery) || content.includes(searchQuery);

        if (shouldShow) {
            hasResults = true;
        }

        note.style.display = shouldShow ? 'flex' : 'none';
    });
    noResultsMessage.style.display = hasResults ? 'none' : 'block';
});

function showMessage(messageId) {
    console.log('message', messageId);
    var message = document.getElementById(messageId);

    if (message) {
        message.style.display = 'block';
    }
}

function hideMessage(messageId) {
    var message = document.getElementById(messageId);

    if (message) {
        message.style.display = 'none';
    }
}


document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (event) {
        var isReminderButton = event.target.closest('.reminder-button');

        if (!isReminderButton) {
            var allNotes = document.querySelectorAll('.note');
            for (var i = 0; i < allNotes.length; i++) {
                var currentNoteId = allNotes[i].getAttribute('data-note-id');
                var reminderPicker = document.getElementById('reminderPicker_' + currentNoteId);

                // Check if the click is inside the reminder picker or its descendants
                if (reminderPicker && reminderPicker.contains(event.target)) {
                    return;
                }

                if (reminderPicker) {
                    reminderPicker.style.display = 'none';
                }
            }
        }
    });
});


function toggleReminderPicker(noteId) {
    // Iterate through all notes and hide their reminder pickers except the current one
    var allNotes = document.querySelectorAll('.note');
    for (var i = 0; i < allNotes.length; i++) {
        var currentNoteId = allNotes[i].getAttribute('data-note-id');
        var reminderPicker = document.getElementById('reminderPicker_' + currentNoteId);

        if (currentNoteId != noteId && reminderPicker) {
            reminderPicker.style.display = 'none';
        }
    }

    // Toggle the visibility of the reminder picker for the current note
    var currentReminderPicker = document.getElementById('reminderPicker_' + noteId);

    if (currentReminderPicker) {
        if (currentReminderPicker.style.display === 'none' || currentReminderPicker.style.display === '') {
            currentReminderPicker.style.display = 'block';
        } else {
            currentReminderPicker.style.display = 'none';
        }
    } else {
        console.error('Reminder picker element not found for note ID ' + noteId);
    }
}

function saveReminder(noteId) {
    var reminderDateId = 'reminderDate_' + noteId;
    var reminderTimeId = 'reminderTime_' + noteId;

    var reminderDateInput = document.getElementById(reminderDateId);
    var reminderTimeInput = document.getElementById(reminderTimeId);

    if (reminderDateInput && reminderTimeInput) {
        var reminderDate = reminderDateInput.value;
        var reminderTime = reminderTimeInput.value;

        var reminderDateTime = new Date(reminderDate + 'T' + reminderTime);

        // Get the current time
        var currentTime = new Date();

        // Calculate the time difference in milliseconds
        var timeDifference = reminderDateTime - currentTime;

        if (timeDifference > 0) {
            // Set up a timeout to show the notification when the reminder time is reached
            setTimeout(function () {
                showNotification('Reminder', 'Time to check your note!');
            }, timeDifference);
        } else {
            console.warn('Invalid reminder time. The specified time has already passed.');
        }

        // AJAX request to save the reminder data
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_reminder.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Prepare the data to send in the POST request
        var data = 'noteId=' + encodeURIComponent(noteId) +
            '&reminderDate=' + encodeURIComponent(reminderDate) +
            '&reminderTime=' + encodeURIComponent(reminderTime);

        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText); // Log the server response
                var reminderPicker = document.getElementById('reminderPicker_' + noteId);
                if (reminderPicker) {
                    reminderPicker.style.display = 'none';
                }


                // Handle the server response as needed
            } else {
                console.error('Error saving reminder. Server returned status:', xhr.status);
            }
        };

        // Send the request with the prepared data
        xhr.send(data);
    } else {
        console.error('Elements not found. Check IDs:', reminderDateId, reminderTimeId);
    }
}

function requestNotificationPermission() {
    Notification.requestPermission().then(function (permission) {
        if (permission === 'granted') {
            console.log('Notification permission granted');
        } else {
            console.warn('Notification permission denied');
        }
    });
}
function showNotification(title, body) {
    if (Notification.permission === 'granted') {
        // Notification permission is already granted
        var notification = new Notification(title, {
            body: body,
            icon: 'path/to/your/icon.png'
        });

        notification.onclick = function () {
            // Handle notification click if needed
            console.log('Notification clicked');
        };
    } else if (Notification.permission === 'denied') {
        console.warn('Notification permission denied');
    } else {
        // Request notification permission
        Notification.requestPermission().then(function (permission) {
            if (permission === 'granted') {
                // Permission granted, show the notification
                var notification = new Notification(title, {
                    body: body,
                    icon: 'path/to/your/icon.png'
                });

                notification.onclick = function () {
                    // Handle notification click if needed
                    console.log('Notification clicked');
                };
            } else {
                console.warn('Notification permission denied');
            }
        });
    }
}



