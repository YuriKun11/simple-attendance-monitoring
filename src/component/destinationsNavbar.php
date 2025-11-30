 <link href="../output.css" rel="stylesheet"> 
 <link rel="stylesheet" href="../assets/css/style.css">

<header class="py-4 mt-4 relative z-20 sticky top-0 z-50 transition duration-300">
    <div class="mx-4 flex justify-between items-center bg-white p-3 md:p-4 rounded-xl shadow-lg shadow-blue-100/50">


        <a href="#" class="flex items-center space-x-2 text-slate-900 font-extrabold text-3xl tracking-tighter nav-link-home">
            <img src="../assets/img/touride.png" alt="TouRide Logo" class="w-auto h-8 md:h-10">
        </a>
        
        <nav class="hidden md:flex space-x-8 text-sm font-semibold text-gray-600">
            <a href="../index.php" class="hover:text-blue-600 transition duration-150 nav-link nav-link-home">Home</a>
        </nav>

        <a href="#" class="btn-login shadow-md hidden md:block">
            Login
        </a>

        <button id="menu-toggle" class="md:hidden text-slate-900 p-2 rounded-lg hover:bg-gray-100 transition duration-150">
            <svg id="menu-icon-open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
            <svg id="menu-icon-close" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
    
    <div id="mobile-menu" class="mobile-menu absolute top-full left-0 right-0 md:hidden bg-white mt-2 p-4 rounded-xl shadow-xl border border-gray-100 transform -translate-y-2 opacity-0 pointer-events-none">
        <nav class="flex flex-col space-y-3 text-base font-medium text-gray-700">
            <a href="../index.php" class="p-2 rounded-lg hover:bg-gray-50 transition duration-150 nav-link nav-link-home">Home</a>
                <a href="../index.php" class="btn-login-mobile">
                    Login
                </a>
        </nav>
    </div>
</header>