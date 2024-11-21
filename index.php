<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #87CEEB; 
        }

        .todo-container {
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        .todo-container h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .input-section {
            display: flex;
            margin-bottom: 15px;
        }

        .input-section input[type="text"] {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 14px;
        }

        .input-section button {
            background-color: #32CD32; 
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 8px;
            transition: background-color 0.3s;
        }

        .input-section button:hover {
            background-color: #28a428; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #32CD32;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #e6f7ff; 
        }

        tr:hover td {
            background-color: #d9f3d9; 
        }

        .action-links {
            text-align: right; 
        }

        .action-links a {
            text-decoration: none;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 14px;
            margin: 0 5px;
            transition: background-color 0.3s;
        }

        .action-links .edit-btn {
            background-color: #007bff; 
        }

        .action-links .edit-btn:hover {
            background-color: #0056b3; 
        }

        .action-links .delete-btn {
            background-color: #ff4d4d; 
        }

        .action-links .delete-btn:hover {
            background-color: #cc0000; 
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .modal-content h2 {
            margin-bottom: 15px;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .modal-buttons button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .modal-buttons .confirm-btn {
            background-color: #ff4d4d;
            color: white;
        }

        .modal-buttons .cancel-btn {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <div class="todo-container">
        <h1>To-Do List</h1>

        <!-- Form to add a new task -->
        <form class="input-section" action="add_task.php" method="POST">
            <input type="text" name="task" placeholder="Enter new task" required>
            <button type="submit">Add Task</button>
        </form>

        <?php include 'db.php'; ?>

        <!-- Task table -->
        <table>
            <tr>
                <th>Task</th>
                <th>Actions</th>
            </tr>
            <?php
            // Fetch and display tasks from the database
            $result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['task']) . "</td>";
                echo "<td class='action-links'>
                        <a href='edit_task.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a>
                        <a href='#' class='delete-btn' onclick='openModal(" . $row['id'] . ")'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this task?</p>
            <div class="modal-buttons">
                <button class="confirm-btn" onclick="confirmDelete()">Delete</button>
                <button class="cancel-btn" onclick="closeModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        let deleteTaskId = null;

        function openModal(taskId) {
            deleteTaskId = taskId;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeModal() {
            deleteTaskId = null;
            document.getElementById('deleteModal').style.display = 'none';
        }

        function confirmDelete() {
            if (deleteTaskId) {
                window.location.href = `delete_task.php?id=${deleteTaskId}`;
            }
        }
    </script>
</body>
</html>
