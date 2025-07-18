<!DOCTYPE html>
<html>
<head>
    <title>Contact Form with AJAX</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#adc178] h-screen flex justify-center items-center">
    <div class="flex justify-center items-center gap-10">
        <!-- FORM -->
        <div class="w-[500px] h-[550px] bg-white rounded-xl shadow-xl overflow-auto transition-all">
            <h1 class="text-center p-6 text-[#bc4749] text-3xl font-bold">Contact Us</h1>
            <form id="form" class="px-10">
                <input type="hidden" id="userId" name="userId">
                <span>Name:</span>
                <input class="border-b-4 w-full focus:outline-none border-[#bc4749]" type="text" name="name" id="name" placeholder="Enter your name" required><br><br>
                <span>Father Name:</span>
                <input class="border-b-4 w-full focus:outline-none border-[#bc4749]" type="text" name="fname" id="fname" placeholder="Enter your father's name" required><br><br>
                <span>Email:</span>
                <input class="border-b-4 w-full focus:outline-none border-[#bc4749]" type="email" name="email" id="email" placeholder="Enter your email" required><br><br>
                <span>Message:</span>
                <textarea class="border-b-4 w-full focus:outline-none border-[#bc4749]" name="message" id="message" placeholder="Enter your message" required></textarea><br><br>
                <div class="flex justify-center">
                    <button type="submit" id="submitBtn" class="bg-[#bc4749] text-white px-6 py-2 rounded-xl hover:bg-[#dde5b6] shadow-xl">
                        Save
                    </button>
                </div>
            </form>
        </div>
        <!-- TABLE -->
        <div class="w-[600px] h-[550px] bg-white rounded-xl shadow-xl overflow-y-auto">
            <table class="w-full table-auto border text-center">
                <thead class="bg-[#bc4749] text-white sticky top-0">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Father Name</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Message</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="text-gray-700"></tbody>
            </table>
        </div>
    </div>
    <!-- JAVASCRIPT -->
    <script>
        $(document).ready(function () {
            loadUsers();
            // Handle form submission
            $('#form').on('submit', function (e) {
                e.preventDefault();
                let userId = $('#userId').val();
                let name = $('#name').val();
                let fname = $('#fname').val();
                let email = $('#email').val();
                let message = $('#message').val();
                let action = userId ? 'update' : 'create';
                $.ajax({
                    url: "data.php",
                    type: "POST",
                    data: { action: action, userId: userId, name: name, fname: fname, email: email, message: message },
                    dataType: 'text',
                    success: function (response) {
                        console.log('Create/Update Response:', typeof response, response);
                        try {
                            let res = JSON.parse(response);
                            console.log('Parsed Response:', res);
                            alert(res.message);
                            if (res.status === 'success') {
                                $('#form')[0].reset();
                                $('#userId').val('');
                                $('#submitBtn').text('Save');
                                loadUsers();
                            }
                        } catch (e) {
                            console.error('JSON Parse Error:', e, 'Response:', response);
                            alert('Invalid response from server.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error, 'Response:', xhr.responseText);
                        alert('Error occurred while saving.');
                    }
                });
            });
            // Load data into table
            function loadUsers() {
                console.log('Loading users...');
                $.ajax({
                    url: 'data.php?t=' + new Date().getTime(), // Prevent caching
                    type: 'GET',
                    success: function (response) {
                        console.log('Load Users Response:', typeof response, response);
                        if (response && response.trim().startsWith('{')) {
                            try {
                                let res = JSON.parse(response);
                                console.log('Parsed Error Response:', res);
                                alert('Error loading users: ' + res.message);
                            } catch (e) {
                                console.error('Unexpected JSON Response:', e, response);
                            }
                        } else {
                            $('#tableBody').html(response || '<tr><td colspan="6">No users found.</td></tr>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error, 'Response:', xhr.responseText);
                        alert('Error occurred while loading users.');
                    }
                });
            }
            // Edit Users
            $(document).on('click', '.editBtn', function () {
                let id = $(this).data('id');
                $.ajax({
                    url: 'data.php',
                    type: 'POST',
                    data: { action: 'edit', id: id },
                    dataType: 'text',
                    success: function (response) {
                        console.log('Edit Response:', typeof response, response);
                        try {
                            let user = JSON.parse(response);
                            console.log('Parsed Response:', user);
                            if (user.status === 'error') {
                                alert(user.message);
                                return;
                            }
                            $('#userId').val(user.id);
                            $('#name').val(user.name);
                            $('#fname').val(user.fname);
                            $('#email').val(user.email);
                            $('#message').val(user.message);
                            $('#submitBtn').text('Update');
                        } catch (e) {
                            console.error('JSON Parse Error:', e, 'Response:', response);
                            alert('Invalid response from server.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error, 'Response:', xhr.responseText);
                        alert('Error occurred while fetching user.');
                    }
                });
            });
            // Delete User
            $(document).on('click', '.deleteBtn', function () {
                if (confirm('Are you sure you want to delete this user?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: 'data.php',
                        type: 'POST',
                        data: { action: 'delete', id: id },
                        dataType: 'text',
                        success: function (response) {
                            console.log('Delete Response:', typeof response, response);
                            try {
                                let res = JSON.parse(response);
                                console.log('Parsed Response:', res);
                                alert(res.message);
                                if (res.status === 'success') {
                                    loadUsers();
                                }
                            } catch (e) {
                                console.error('JSON Parse Error:', e, 'Response:', response);
                                alert('Invalid response from server.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX Error:', status, error, 'Response:', xhr.responseText);
                            alert('Error occurred while deleting user.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>