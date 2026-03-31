@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Manajemen Kas Digital</h1>
        <p class="text-gray-600">{{ \Carbon\Carbon::now()->locale('id')->format('F Y') }}</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600">Kas Masuk</p>
                    <p class="text-2xl font-bold text-green-700">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-600">Kas Keluar</p>
                    <p class="text-2xl font-bold text-red-700">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600">Saldo Akhir</p>
                    <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <button onclick="openTransactionModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Transaksi
        </button>
        
        <div class="flex gap-2">
            <button onclick="filterTransactions('all')" class="filter-btn px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                Semua
            </button>
            <button onclick="filterTransactions('income')" class="filter-btn px-4 py-3 bg-green-200 text-green-700 rounded-lg hover:bg-green-300 transition font-medium">
                Masuk
            </button>
            <button onclick="filterTransactions('expense')" class="filter-btn px-4 py-3 bg-red-200 text-red-700 rounded-lg hover:bg-red-300 transition font-medium">
                Keluar
            </button>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Transaksi</h2>
        </div>
        
        <div id="transactions-container" class="divide-y">
            <!-- Transactions will be loaded here -->
        </div>
        
        <!-- Empty State -->
        <div id="empty-state" class="text-center py-12 hidden">
            <div class="text-gray-400 text-6xl mb-4">📝</div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada transaksi</h3>
            <p class="text-gray-500">Klik "Tambah Transaksi" untuk memulai</p>
        </div>
        
        <!-- Loading State -->
        <div id="loading" class="text-center py-8 hidden">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
            <p class="mt-2 text-gray-600">Memuat data...</p>
        </div>
    </div>
</div>

<!-- Transaction Modal -->
<div id="transaction-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Transaksi</h3>
                <button onclick="closeTransactionModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="transaction-form" onsubmit="saveTransaction(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" name="type" value="income" class="peer sr-only" checked>
                            <div class="border-2 border-gray-200 rounded-lg p-3 cursor-pointer text-center peer-checked:border-green-500 peer-checked:bg-green-50 hover:bg-gray-50">
                                <div class="text-green-600 font-medium">Kas Masuk</div>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="type" value="expense" class="peer sr-only">
                            <div class="border-2 border-gray-200 rounded-lg p-3 cursor-pointer text-center peer-checked:border-red-500 peer-checked:bg-red-50 hover:bg-gray-50">
                                <div class="text-red-600 font-medium">Kas Keluar</div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Nominal (Rp)</label>
                    <input type="number" id="amount" name="amount" required min="1" step="0.01" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="0">
                </div>
                
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Nama Siswa (Opsional)</label>
                    <select id="student_id" name="student_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <input type="text" id="description" name="description" required maxlength="255"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Contoh: Kas mingguan">
                </div>
                
                <div class="mb-6">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" id="date" name="date" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ now()->format('Y-m-d') }}">
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition">
                        Simpan
                    </button>
                    <button type="button" onclick="closeTransactionModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg font-medium transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Toast -->
<div id="success-toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full transition-transform duration-300 z-50">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span id="toast-message">Transaksi berhasil disimpan!</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let transactions = [];
    let currentFilter = 'all';
    
    loadTransactions();
    
    function loadTransactions() {
        console.log('Loading transactions...');
        showLoading();
        // Add cache-busting parameter
        const timestamp = new Date().getTime();
        fetch('{{ route("bendahara.api.transactions") }}?t=' + timestamp)
            .then(response => response.json())
            .then(data => {
                console.log('Transactions loaded:', data);
                transactions = data.transactions;
                updateSummary(data.summary);
                renderTransactions();
                hideLoading();
            })
            .catch(error => {
                console.error('Error loading transactions:', error);
                hideLoading();
            });
    }
    
    function renderTransactions() {
        const container = document.getElementById('transactions-container');
        const emptyState = document.getElementById('empty-state');
        
        // Filter transactions
        let filteredTransactions = transactions;
        if (currentFilter !== 'all') {
            filteredTransactions = transactions.filter(t => t.type === currentFilter);
        }
        
        if (filteredTransactions.length === 0) {
            container.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        }
        
        emptyState.classList.add('hidden');
        container.innerHTML = filteredTransactions.map(transaction => createTransactionCard(transaction)).join('');
        
        // Add delete handlers
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                deleteTransaction(id);
            });
        });
    }
    
    function createTransactionCard(transaction) {
        const isIncome = transaction.type === 'income';
        const amountColor = isIncome ? 'text-green-600' : 'text-red-600';
        const bgColor = isIncome ? 'bg-green-50' : 'bg-red-50';
        const borderColor = isIncome ? 'border-green-200' : 'border-red-200';
        const sign = isIncome ? '+' : '-';
        
        return `
            <div class="p-4 hover:bg-gray-50 transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="${bgColor} ${borderColor} border px-2 py-1 rounded text-xs font-medium ${amountColor}">
                                ${isIncome ? 'Masuk' : 'Keluar'}
                            </div>
                            <h3 class="font-medium text-gray-900">${transaction.description}</h3>
                        </div>
                        <div class="text-sm text-gray-500">
                            ${transaction.student ? `${transaction.student.name} • ` : ''}
                            ${new Date(transaction.date).toLocaleDateString('id-ID')} • 
                            ${transaction.creator ? transaction.creator.name : 'System'}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-lg ${amountColor}">
                            ${sign} Rp ${Number(transaction.amount).toLocaleString('id-ID')}
                        </div>
                        <button class="delete-btn text-gray-400 hover:text-red-600 text-sm mt-1" data-id="${transaction.id}">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
    
    function updateSummary(summary) {
        document.querySelector('.text-green-700').textContent = `Rp ${Number(summary.totalIncome).toLocaleString('id-ID')}`;
        document.querySelector('.text-red-700').textContent = `Rp ${Number(summary.totalExpense).toLocaleString('id-ID')}`;
        document.querySelector('.text-blue-700').textContent = `Rp ${Number(summary.balance).toLocaleString('id-ID')}`;
    }
    
    function filterTransactions(type) {
        currentFilter = type;
        
        // Update button styles
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('ring-2', 'ring-offset-2', 'ring-blue-500');
        });
        event.target.classList.add('ring-2', 'ring-offset-2', 'ring-blue-500');
        
        renderTransactions();
    }
    
    function showLoading() {
        document.getElementById('loading').classList.remove('hidden');
        document.getElementById('transactions-container').classList.add('hidden');
    }
    
    function hideLoading() {
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('transactions-container').classList.remove('hidden');
    }
    
    window.openTransactionModal = function() {
        document.getElementById('transaction-modal').classList.remove('hidden');
    }
    
    window.closeTransactionModal = function() {
        document.getElementById('transaction-modal').classList.add('hidden');
        document.getElementById('transaction-form').reset();
    }
    
    window.saveTransaction = function(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData);
        
        fetch('{{ route("bendahara.kas.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            console.log('Save transaction result:', result);
            if (result.success) {
                closeTransactionModal();
                // Add small delay to ensure database is updated
                setTimeout(() => {
                    loadTransactions();
                }, 500);
                showToast('Transaksi berhasil ditambahkan!');
            } else {
                showToast('Gagal menambah transaksi: ' + (result.message || 'Unknown error'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan', 'error');
        });
    }
    
    window.deleteTransaction = function(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
            return;
        }
        
        fetch(`/bendahara/transactions/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                loadTransactions();
                showToast('Transaksi berhasil dihapus!');
            } else {
                showToast('Gagal menghapus transaksi', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan', 'error');
        });
    }
    
    window.showToast = function(message, type = 'success') {
        const toast = document.getElementById('success-toast');
        const toastMessage = document.getElementById('toast-message');
        
        toastMessage.textContent = message;
        
        if (type === 'error') {
            toast.className = toast.className.replace('bg-green-500', 'bg-red-500');
        } else {
            toast.className = toast.className.replace('bg-red-500', 'bg-green-500');
        }
        
        toast.classList.remove('translate-y-full');
        
        setTimeout(() => {
            toast.classList.add('translate-y-full');
        }, 3000);
    }
    
    // Close modal when clicking outside
    document.getElementById('transaction-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeTransactionModal();
        }
    });
});
</script>
@endsection