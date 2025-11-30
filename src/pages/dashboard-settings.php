<?php
require '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

if (isset($_POST['update_info'])) {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!$full_name || !$email) {
        $message = 'Name and email are required.';
    } else {
        $full_name_clean = trim($full_name);
        $email_clean = filter_var(trim($email), FILTER_SANITIZE_EMAIL);

        $stmt = $conn->prepare("UPDATE users SET full_name=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $full_name_clean, $email_clean, $user_id);
        if ($stmt->execute()) {
            $message = 'Profile updated successfully!';
            $_SESSION['user_name'] = $full_name_clean;
        } else {
            $message = 'Failed to update profile.';
        }
        $stmt->close();
    }
}

if (isset($_POST['update_password'])) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!$password || !$confirm_password) {
         $message = 'Both password fields must be filled.';
    } elseif ($password !== $confirm_password) {
        $message = 'Passwords do not match.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $hashed_password, $user_id);
        if ($stmt->execute()) {
            $message = 'Password updated successfully!';
        } else {
            $message = 'Failed to update password.';
        }
        $stmt->close();
    }
}

$stmt = $conn->prepare("SELECT full_name, email FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email);
$stmt->fetch();
$stmt->close();
?>

<div class="w-full flex justify-center bg-gray-50 py-8 sm:py-10">
    <div class="w-full lg:max-w-2xl bg-white rounded-xl shadow-2xl border border-gray-200 p-6 sm:p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3 flex items-center">
            <i class="fas fa-user-cog text-blue-600 mr-2"></i> Account Settings
        </h2>

        <?php if ($message): ?>
            <div class="mb-5 p-3 rounded-lg flex items-center 
                <?php echo strpos($message, 'successfully') !== false 
                    ? 'bg-green-50 text-green-800 border-l-4 border-green-500' 
                    : 'bg-red-50 text-red-800 border-l-4 border-red-500'; ?> 
                font-medium shadow-sm text-sm">
                <i class="
                    <?php echo strpos($message, 'successfully') !== false 
                        ? 'fas fa-check-circle text-green-500' 
                        : 'fas fa-exclamation-triangle text-red-500'; ?>
                    mr-2 text-md">
                </i>
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>

        <h3 class="text-lg font-semibold text-gray-800 mb-3 pt-3 border-t-2 border-blue-500/20">Profile Information</h3>
        <form id="infoForm" method="POST" class="space-y-4">
            <input type="hidden" name="update_info" value="1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required 
                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm transition focus:ring-2 focus:ring-blue-300 focus:border-blue-500 placeholder-gray-400">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required 
                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm transition focus:ring-2 focus:ring-blue-300 focus:border-blue-500 placeholder-gray-400">
                </div>
            </div>
            <div class="flex justify-end pt-2">
                <button type="button" onclick="confirmSubmit('infoForm', 'Are you sure you want to update your profile information?')" 
                    class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-full text-sm shadow-md hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-save mr-1"></i> Save Changes
                </button>
            </div>
        </form>

        <hr class="my-6 border-gray-200">

        <h3 class="text-lg font-semibold text-gray-800 mb-3">Change Password</h3>
        <form id="passwordForm" method="POST" class="space-y-4">
            <input type="hidden" name="update_password" value="1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" id="password" name="password" minlength="6" required
                        class="w-full border border-gray-300 rounded-lg p-2.5 pr-10 text-sm transition focus:ring-2 focus:ring-blue-300 focus:border-blue-500 placeholder-gray-400" 
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword('password', 'togglePasswordIcon')" 
                        class="absolute top-1/2 -translate-y-1/4 right-3 text-gray-500 hover:text-gray-700 p-1 text-sm"
                        aria-label="Toggle password visibility">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                <div class="relative">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" minlength="6" required
                        class="w-full border border-gray-300 rounded-lg p-2.5 pr-10 text-sm transition focus:ring-2 focus:ring-blue-300 focus:border-blue-500 placeholder-gray-400" 
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword('confirm_password', 'toggleConfirmIcon')" 
                        class="absolute top-1/2 -translate-y-1/4 right-3 text-gray-500 hover:text-gray-700 p-1 text-sm"
                        aria-label="Toggle confirm password visibility">
                        <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                    </button>
                </div>
            </div>
            <div class="flex justify-end pt-2">
                <button type="button" onclick="confirmSubmit('passwordForm', 'Are you sure you want to change your password? This action cannot be undone.')" 
                    class="bg-red-500 text-white font-semibold px-6 py-2 rounded-full text-sm shadow-md hover:bg-red-600 transition duration-300">
                    <i class="fas fa-lock mr-1"></i> Change Password
                </button>
            </div>
        </form>
    </div>
</div>

<div id="confirmModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 transition-opacity duration-300 ease-out">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-11/12 max-w-xs transform scale-95 transition-transform duration-300 ease-out">
        <div class="flex items-center mb-4">
            <div class="bg-yellow-100 p-2 rounded-full text-yellow-600 mr-3">
                <i class="fas fa-exclamation-triangle text-lg"></i>
            </div>
            <h4 class="text-lg font-bold text-gray-800">Confirm Action</h4>
        </div>
        <p id="confirmMessage" class="text-gray-600 mb-5 text-sm"></p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeModal()" 
                class="px-4 py-1.5 rounded-full text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium text-sm transition duration-200">
                Cancel
            </button>
            <button id="confirmYes" 
                class="px-4 py-1.5 rounded-full bg-blue-600 text-white font-medium text-sm hover:bg-blue-700 transition duration-200 shadow-sm">
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

let formToSubmit = ''; 

function confirmSubmit(formId, message) {
    const form = document.getElementById(formId);

    if (formId === 'passwordForm') {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');
        if (!form.checkValidity() || !passwordInput.value || !confirmInput.value) {
            if (!passwordInput.value) {
                passwordInput.reportValidity();
            } else if (!confirmInput.value) {
                confirmInput.reportValidity();
            }
            return; 
        }
    }

    const modal = document.getElementById('confirmModal');
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmYes = document.getElementById('confirm1Yes');
    
    formToSubmit = formId; 
    
    confirmMessage.textContent = message;
    
    confirmYes.onclick = function() {
        form.submit();
        closeModal();
    }

    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector(':scope > div').classList.remove('scale-95');
        modal.style.opacity = '1';
    }, 10); 
}

function closeModal() {
    const modal = document.getElementById('confirmModal');
    modal.querySelector(':scope > div').classList.add('scale-95');
    modal.style.opacity = '0';

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300); 
}
</script>