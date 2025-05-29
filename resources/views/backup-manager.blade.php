@extends('layouts.adminLayout')

@section('title', 'Gestionnaire de Sauvegardes')

@section('content')
    <div class="min-h-screen bg-gray-100 py-6">
        @livewire('Sauvegarde')
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    /* Animations personnalisées */
    @keyframes slideIn {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .slide-in {
        animation: slideIn 0.3s ease-out;
    }
    
    /* Effet de pulsation pour les éléments en cours */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }
    
    .pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Hover effects personnalisés */
    .backup-card {
        transition: all 0.3s ease;
    }
    
    .backup-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* Progress bar stylée */
    .progress-bar {
        background: linear-gradient(90deg, #3B82F6, #1D4ED8);
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }
</style>
@endpush

@push('scripts')
<script>
    // Script pour les notifications toast
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 slide-in ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // Écouter les événements Livewire globaux
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('backupCreated', (message) => {
            showToast(message, 'success');
        });
        
        Livewire.on('backupError', (message) => {
            showToast(message, 'error');
        });
        
        Livewire.on('backupDeleted', (message) => {
            showToast(message, 'success');
        });
    });
    
    // Fonction pour formater la taille des fichiers
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Auto-refresh des données toutes les 30 secondes
    setInterval(() => {
        if (typeof Livewire !== 'undefined') {
            Livewire.emit('refreshBackups');
        }
    }, 30000);
</script>
@endpush