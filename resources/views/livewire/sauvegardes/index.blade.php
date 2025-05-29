<div x-data="backupManager()" 
     x-init="init()"
     class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-lg"
     x-cloak>
     
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestionnaire de Sauvegardes</h1>
            <p class="text-gray-600 mt-1">Gérez vos sauvegardes de base de données</p>
        </div>
        
        <div class="flex space-x-3">
            <button @click="$wire.showSettings = true"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-cog mr-2"></i>Paramètres
            </button>
            
            <button @click="createBackup()"
                    :disabled="isCreating"
                    class="bg-blue-500 hover:bg-blue-600 disabled:bg-blue-300 text-white px-6 py-2 rounded-lg transition duration-200">
                <span x-show="!isCreating">
                    <i class="fas fa-plus mr-2"></i>Nouvelle Sauvegarde
                </span>
                <span x-show="isCreating" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Création...
                </span>
            </button>
        </div>
    </div>

    <!-- Messages Flash -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition
             @click="show = false"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 cursor-pointer">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition
             @click="show = false"
             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 cursor-pointer">
            {{ session('error') }}
        </div>
    @endif

    <!-- Barre de progression -->
    <div x-show="$wire.isCreatingBackup" 
         x-transition
         class="mb-6">
        <div class="bg-gray-200 rounded-full h-3">
            <div class="bg-blue-500 h-3 rounded-full transition-all duration-500"
                 :style="`width: ${$wire.backupProgress}%`"></div>
        </div>
        <p class="text-sm text-gray-600 mt-2">Création en cours... <span x-text="$wire.backupProgress + '%'"></span></p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-database text-blue-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Total Sauvegardes</p>
                    <p class="text-2xl font-bold text-blue-600">{{ count($this->filteredBackups) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-clock text-green-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Dernière Sauvegarde</p>
                    <p class="text-sm font-semibold text-green-600">
                        @if(count($this->filteredBackups) > 0)
                            {{ \Carbon\Carbon::parse($this->filteredBackups[0]['created_at'])->diffForHumans() }}
                        @else
                            Aucune
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-yellow-50 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-hdd text-yellow-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Espace Utilisé</p>
                    <p class="text-sm font-semibold text-yellow-600" x-text="totalSize"></p>
                </div>
            </div>
        </div>
        
        <div class="bg-purple-50 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-sync text-purple-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Auto-Backup</p>
                    <p class="text-sm font-semibold text-purple-600">
                        {{ $autoBackupEnabled ? 'Activé' : 'Désactivé' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre d'outils -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
        <!-- Recherche -->
        <div class="relative">
            <input wire:model.debounce.300ms="searchTerm" 
                   type="text" 
                   placeholder="Rechercher une sauvegarde..."
                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>

        <!-- Actions sélection multiple -->
        <div x-show="selectedBackups.length > 0" 
             x-transition
             class="flex items-center space-x-3">
            <span class="text-sm text-gray-600" x-text="`${selectedBackups.length} sélectionné(s)`"></span>
            <button @click="downloadSelected()"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                <i class="fas fa-download mr-1"></i>Télécharger
            </button>
            <button @click="deleteSelected()"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                <i class="fas fa-trash mr-1"></i>Supprimer
            </button>
        </div>

        <!-- Bouton actualiser -->
        <button @click="$wire.loadBackups()"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-sync-alt mr-2"></i>Actualiser
        </button>
    </div>

    <!-- Tableau des sauvegardes -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <input type="checkbox" 
                               @change="toggleSelectAll($event.target.checked)"
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        @click="$wire.sortBy('filename')">
                        <div class="flex items-center">
                            Nom du Fichier
                            <i class="fas fa-sort ml-2"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        @click="$wire.sortBy('size')">
                        <div class="flex items-center">
                            Taille
                            <i class="fas fa-sort ml-2"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        @click="$wire.sortBy('created_at')">
                        <div class="flex items-center">
                            Date de Création
                            <i class="fas fa-sort ml-2"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($this->filteredBackups as $backup)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <input type="checkbox" 
                                   :checked="selectedBackups.includes('{{ $backup['path'] }}')"
                                   @change="toggleBackupSelection('{{ $backup['path'] }}')"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="fas fa-database text-blue-500 mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $backup['filename'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $backup['path'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($backup['size'] / 1024, 2) }} KB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>{{ \Carbon\Carbon::parse($backup['created_at'])->format('d/m/Y H:i:s') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($backup['created_at'])->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button @click="$wire.downloadBackup('{{ $backup['path'] }}')"
                                        class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <button @click="$wire.confirmRestore('{{ $backup['path'] }}')"
                                        class="text-green-600 hover:text-green-900 bg-green-100 hover:bg-green-200 px-3 py-1 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <button @click="$wire.confirmDelete('{{ $backup['path'] }}')"
                                        class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 rounded transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-database text-6xl mb-4"></i>
                                <p class="text-xl">Aucune sauvegarde trouvée</p>
                                <p class="text-sm mt-2">Créez votre première sauvegarde pour commencer</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div x-show="$wire.showConfirmDelete" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
         style="display: none;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Confirmer la suppression</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Êtes-vous sûr de vouloir supprimer cette sauvegarde ? Cette action est irréversible.
                    </p>
                </div>
                <div class="items-center px-4 py-3 flex justify-center space-x-4">
                    <button @click="$wire.showConfirmDelete = false"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600">
                        Annuler
                    </button>
                    <button @click="$wire.deleteBackup()"
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de restauration -->
    <div x-show="$wire.showRestoreModal" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
         style="display: none;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <i class="fas fa-undo text-yellow-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Confirmer la restauration</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Êtes-vous sûr de vouloir restaurer cette sauvegarde ? Cela remplacera toutes les données actuelles.
                    </p>
                </div>
                <div class="items-center px-4 py-3 flex justify-center space-x-4">
                    <button @click="$wire.showRestoreModal = false"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600">
                        Annuler
                    </button>
                    <button @click="$wire.restoreBackup()"
                            class="px-4 py-2 bg-yellow-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-yellow-700">
                        Restaurer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal des paramètres -->
    <div x-show="$wire.showSettings" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
         style="display: none;">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cog mr-2"></i>Paramètres de Sauvegarde
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   wire:model="autoBackupEnabled"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm">Activer les sauvegardes automatiques</span>
                        </label>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fréquence</label>
                        <select wire:model="backupFrequency" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="hourly">Chaque heure</option>
                            <option value="daily">Quotidien</option>
                            <option value="weekly">Hebdomadaire</option>
                            <option value="monthly">Mensuel</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre max de sauvegardes</label>
                        <input type="number" 
                               wire:model="maxBackups" 
                               min="1" 
                               max="100"
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button @click="$wire.showSettings = false"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </button>
                    <button @click="$wire.updateSettings()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Sauvegarder
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function backupManager() {
            return {
                selectedBackups: [],
                isCreating: false,
                totalSize: '0 KB',
                
                init() {
                    this.calculateTotalSize();
                    
                    // Écouter les événements Livewire
                    Livewire.on('updateProgress', (progress) => {
                        this.isCreating = progress < 100;
                    });
                },
                
                calculateTotalSize() {
                    let total = 0;
                    @foreach($this->filteredBackups as $backup)
                        total += {{ $backup['size'] }};
                    @endforeach
                    
                    if (total > 1024 * 1024) {
                        this.totalSize = (total / (1024 * 1024)).toFixed(2) + ' MB';
                    } else {
                        this.totalSize = (total / 1024).toFixed(2) + ' KB';
                    }
                },
                
                toggleSelectAll(checked) {
                    if (checked) {
                        this.selectedBackups = [
                            @foreach($this->filteredBackups as $backup)
                                '{{ $backup['path'] }}',
                            @endforeach
                        ];
                    } else {
                        this.selectedBackups = [];
                    }
                },
                
                toggleBackupSelection(backupPath) {
                    const index = this.selectedBackups.indexOf(backupPath);
                    if (index > -1) {
                        this.selectedBackups.splice(index, 1);
                    } else {
                        this.selectedBackups.push(backupPath);
                    }
                },
                
                async createBackup() {
                    this.isCreating = true;
                    try {
                        await @this.createBackup();
                    } finally {
                        this.isCreating = false;
                        this.calculateTotalSize();
                    }
                },
                
                downloadBackup(backupPath) {
                    window.location.href = `/backup/download/${encodeURIComponent(backupPath.split('/').pop())}`;
                },
                
                downloadSelected() {
                    this.selectedBackups.forEach(backupPath => {
                        this.downloadBackup(backupPath);
                    });
                },
                
                deleteSelected() {
                    if (confirm(`Êtes-vous sûr de vouloir supprimer ${this.selectedBackups.length} sauvegarde(s) ?`)) {
                        @this.deleteSelected();
                        this.selectedBackups = [];
                    }
                }
            }
        }
    </script>
</div>