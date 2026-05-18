@extends('layouts.dashboard')

@section('content')
  <div class="mb-10">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-4xl font-black text-white mb-2">DASHBOARD</h1>
        <p class="text-slate-400 text-lg">GameDock Administration Panel</p>
      </div>
      <div class="text-right">
        <p class="text-sm text-slate-400">{{ now()->format('l, d F Y') }}</p>
        <p class="text-xs text-slate-500 mt-1">Last updated: {{ now()->format('H:i') }} WIB</p>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

    <div class="group relative overflow-hidden bg-gradient-to-br from-[#1e3a5c] to-[#2d5a8c] rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-all duration-500 hover:shadow-blue-500/25">
      <div class="absolute top-0 right-0 mt-4 mr-4 opacity-10 group-hover:opacity-20 transition-opacity">
        <svg class="w-24 h-24 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
      </div>
      <div class="relative z-10">
        <div class="flex items-center gap-2 mb-3">
          <div class="w-10 h-10 bg-blue-400/20 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
          </div>
          <span class="text-blue-200 text-sm font-bold uppercase tracking-widest">Total Games</span>
        </div>
        <p class="text-5xl font-black text-white mb-1">{{ $totalGames ?? 0 }}</p>
        <p class="text-blue-200 text-xs">Active games in catalogue</p>
      </div>
      <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-300 to-transparent opacity-50"></div>
    </div>

    <div class="group relative overflow-hidden bg-gradient-to-br from-[#2d1e5c] to-[#4d2d8c] rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-all duration-500 hover:shadow-purple-500/25">
      <div class="absolute top-0 right-0 mt-4 mr-4 opacity-10 group-hover:opacity-20 transition-opacity">
        <svg class="w-24 h-24 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
      </div>
      <div class="relative z-10">
        <div class="flex items-center gap-2 mb-3">
          <div class="w-10 h-10 bg-purple-400/20 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </div>
          <span class="text-purple-200 text-sm font-bold uppercase tracking-widest">Total Users</span>
        </div>
        <p class="text-5xl font-black text-white mb-1">{{ $totalUsers ?? 0 }}</p>
        <div class="flex gap-4 text-xs">
          <span class="text-purple-200">{{ $regularUsers ?? 0 }} Players</span>
          <span class="text-purple-300">|</span>
          <span class="text-purple-200">{{ $adminUsers ?? 0 }} Admins</span>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-purple-300 to-transparent opacity-50"></div>
    </div>

    <div class="group relative overflow-hidden bg-gradient-to-br from-[#1e3a1c] to-[#2d5a2c] rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-all duration-500 hover:shadow-green-500/25">
      <div class="absolute top-0 right-0 mt-4 mr-4 opacity-10 group-hover:opacity-20 transition-opacity">
        <svg class="w-24 h-24 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
      </div>
      <div class="relative z-10">
        <div class="flex items-center gap-2 mb-3">
          <div class="w-10 h-10 bg-green-400/20 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
          </div>
          <span class="text-green-200 text-sm font-bold uppercase tracking-widest">Transactions</span>
        </div>
        <p class="text-5xl font-black text-white mb-1">{{ $totalTransactions ?? 0 }}</p>
        <p class="text-green-200 text-xs">Total transactions</p>
      </div>
      <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-green-300 to-transparent opacity-50"></div>
    </div>

    <div class="group relative overflow-hidden bg-gradient-to-br from-[#3a2e1c] to-[#5a4e2c] rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-all duration-500 hover:shadow-yellow-500/25">
      <div class="absolute top-0 right-0 mt-4 mr-4 opacity-10 group-hover:opacity-20 transition-opacity">
        <svg class="w-24 h-24 text-yellow-200" xmlns="http://www.w3.org/2000/svg" viewBox="-32 -32 1088 1088" fill="currentColor"><g transform="translate(0, 960) scale(1, -1)"><path d="M40.515 259.265h259.562v-344.598h-259.562zM211.033 170.222h-81.475v-166.511h81.475zM722.143 599.857h259.562v-685.19h-259.562zM892.661 510.813h-81.475v-507.103h81.475zM381.551 429.784h259.562v-515.117h-259.562zM552.070 340.74h-81.475v-337.030h81.475zM1022.219-85.333h-1022.219v89.043h1022.219zM532.48 553.554h-149.148v89.043h149.148c10.573 0 19.144 8.571 19.144 19.144v0 0.312c0 0.040 0 0.087 0 0.134 0 10.573-8.571 19.144-19.144 19.144 0 0 0 0 0 0h-44.522c-0.046 0-0.101 0-0.156 0-59.873 0-108.411 48.537-108.411 108.411 0 59.819 48.448 108.322 108.246 108.41h149.468v-89.043h-148.925c-10.713-0.15-19.343-8.858-19.367-19.587v-0.002c0-10.573 8.571-19.144 19.144-19.144v0h44.522c59.873 0 108.41-48.537 108.41-108.41s-48.537-108.41-108.41-108.41v0zM555.631 853.63h-89.043v85.037h89.043zM555.631 512.594h-89.043v85.482h89.043z"/></g></svg>
      </div>
      <div class="relative z-10">
        <div class="flex items-center gap-2 mb-3">
          <div class="w-10 h-10 bg-yellow-400/20 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-yellow-300" xmlns="http://www.w3.org/2000/svg" viewBox="-32 -32 1088 1088" fill="currentColor"><g transform="translate(0, 960) scale(1, -1)"><path d="M40.515 259.265h259.562v-344.598h-259.562zM211.033 170.222h-81.475v-166.511h81.475zM722.143 599.857h259.562v-685.19h-259.562zM892.661 510.813h-81.475v-507.103h81.475zM381.551 429.784h259.562v-515.117h-259.562zM552.070 340.74h-81.475v-337.030h81.475zM1022.219-85.333h-1022.219v89.043h1022.219zM532.48 553.554h-149.148v89.043h149.148c10.573 0 19.144 8.571 19.144 19.144v0 0.312c0 0.040 0 0.087 0 0.134 0 10.573-8.571 19.144-19.144 19.144h-44.522c-59.873 0-108.411 48.537-108.411 108.411 0 59.819 48.448 108.322 108.246 108.41h149.468v-89.043h-148.925c-10.713-0.15-19.343-8.858-19.367-19.587c0-10.573 8.571-19.144 19.144-19.144h44.522c59.873 0 108.41-48.537 108.41-108.41s-48.537-108.41-108.41-108.41zM555.631 853.63h-89.043v85.037h89.043zM555.631 512.594h-89.043v85.482h89.043z"/></g></svg>
          </div>
          <span class="text-yellow-200 text-sm font-bold uppercase tracking-widest">Revenue</span>
        </div>
        <p class="text-5xl font-black text-white mb-1">Rp {{ isset($totalRevenue) ? number_format($totalRevenue, 0, ',', '.') : '0' }}</p>
        <p class="text-yellow-200 text-xs">From approved transactions</p>
      </div>
      <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-300 to-transparent opacity-50"></div>
    </div>

    <div class="group relative overflow-hidden bg-gradient-to-br from-[#3a2a1c] to-[#5a4a2c] rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-all duration-500 hover:shadow-orange-500/25">
      <div class="absolute top-0 right-0 mt-4 mr-4 opacity-10 group-hover:opacity-20 transition-opacity">
        <svg class="w-24 h-24 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <div class="relative z-10">
        <div class="flex items-center gap-2 mb-3">
          <div class="w-10 h-10 bg-orange-400/20 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <span class="text-orange-200 text-sm font-bold uppercase tracking-widest">Pending</span>
        </div>
        <p class="text-5xl font-black text-white mb-1">{{ $pendingCount ?? 0 }}</p>
        <p class="text-orange-200 text-xs">Awaiting approval</p>
      </div>
      <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-orange-300 to-transparent opacity-50"></div>
    </div>

    <div class="group relative overflow-hidden bg-gradient-to-br from-[#1e3a3a] to-[#2d5a5a] rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-all duration-500 hover:shadow-teal-500/25">
      <div class="absolute top-0 right-0 mt-4 mr-4 opacity-10 group-hover:opacity-20 transition-opacity">
        <svg class="w-24 h-24 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <div class="relative z-10">
        <div class="flex items-center gap-2 mb-3">
          <div class="w-10 h-10 bg-teal-400/20 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <span class="text-teal-200 text-sm font-bold uppercase tracking-widest">Completed</span>
        </div>
        <p class="text-5xl font-black text-white mb-1">{{ $completedCount ?? 0 }}</p>
        <p class="text-teal-200 text-xs">Successfully processed</p>
      </div>
      <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-teal-300 to-transparent opacity-50"></div>
    </div>
  </div>

  @if(isset($latestTransactions) && $latestTransactions->count())
  <div class="dark-panel overflow-hidden">
    <div class="dark-panel-header flex items-center justify-between">
      <div>
        <h3 class="text-lg font-black text-white">Recent Transactions</h3>
        <p class="text-xs text-slate-400 mt-0.5">Latest 5 transactions across the platform</p>
      </div>
      <a href="{{ route('admin.transactions.index') }}" class="text-sm text-[#4b76c4] hover:text-[#62a0f0] font-semibold transition">View All →</a>
    </div>
    <div class="overflow-x-auto">
      <table class="steam-table">
        <thead>
          <tr>
            <th class="w-20">Transaction</th>
            <th>User</th>
            <th>Amount</th>
            <th class="text-center w-24">Status</th>
            <th>Date</th>
            <th class="w-24 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($latestTransactions as $tx)
          <tr>
            <td>
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600/20 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div>
                  <p class="text-sm font-bold text-white">#{{ $tx->id }}</p>
                  <p class="text-xs text-slate-500">{{ $tx->items->count() }} items</p>
                </div>
              </div>
            </td>
            <td>
              <p class="text-sm font-semibold text-slate-200">{{ $tx->user?->name ?? 'User '.$tx->user_id }}</p>
              <p class="text-xs text-slate-500">{{ $tx->user?->email ?? '-' }}</p>
            </td>
            <td><p class="text-sm font-bold text-green-400">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</p></td>
            <td class="text-center"><span class="status-{{ $tx->status }}">{{ ucfirst($tx->status) }}</span></td>
            <td>
              <p class="text-sm text-slate-300">{{ $tx->created_at->format('d M Y') }}</p>
              <p class="text-xs text-slate-500">{{ $tx->created_at->format('H:i') }}</p>
            </td>
            <td class="text-center">
              <a href="{{ route('admin.transactions.show', $tx) }}" class="steam-btn-sm">Details</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif

  <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('admin.games.create') }}" class="group flex items-center gap-4 p-5 bg-[#0b1b2b] hover:bg-[#1b2536] rounded-xl border border-white/10 hover:border-[#4b76c4]/30 transition-all duration-300">
      <div class="w-12 h-12 bg-blue-600/20 rounded-xl flex items-center justify-center group-hover:bg-blue-600/30 transition">
        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
      </div>
      <div>
        <p class="font-bold text-white">Add New Game</p>
        <p class="text-xs text-slate-400">Expand the catalogue</p>
      </div>
    </a>

    <a href="{{ route('admin.transactions.index') }}" class="group flex items-center gap-4 p-5 bg-[#0b1b2b] hover:bg-[#1b2536] rounded-xl border border-white/10 hover:border-purple-500/30 transition-all duration-300">
      <div class="w-12 h-12 bg-purple-600/20 rounded-xl flex items-center justify-center group-hover:bg-purple-600/30 transition">
        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
        </svg>
      </div>
      <div>
        <p class="font-bold text-white">Manage Transactions</p>
        <p class="text-xs text-slate-400">Review &amp; approve</p>
      </div>
    </a>

    <a href="{{ route('games.index') }}" class="group flex items-center gap-4 p-5 bg-[#0b1b2b] hover:bg-[#1b2536] rounded-xl border border-white/10 hover:border-green-500/30 transition-all duration-300">
      <div class="w-12 h-12 bg-green-600/20 rounded-xl flex items-center justify-center group-hover:bg-green-600/30 transition">
        <svg class="w-6 h-6 text-green-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path fill-rule="evenodd" d="M5.75 1a.75.75 0 1 0 0 1.5h4.5a.75.75 0 1 0 0-1.5zm-2 2.5a.75.75 0 1 0 0 1.5h8.5a.75.75 0 1 0 0-1.5zm-1.25 4v6h11v-6zM2 6a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1zm8.28 3.83a.75.75 0 1 0-1.06-1.06l-1.97 1.97l-.47-.47a.75.75 0 1 0-1.06 1.06l1 1a.75.75 0 0 0 1.06 0z" clip-rule="evenodd"/></svg>
      </div>
      <div>
        <p class="font-bold text-white">View Catalogue</p>
        <p class="text-xs text-slate-400">Browse games</p>
      </div>
    </a>
  </div>
@endsection
