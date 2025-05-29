export default function backupStats() {
    return {
        stats: {
            total: 0,
            totalSize: 0,
            lastBackup: null,
            autoBackupStatus: false
        },
        
        init() {
            this.loadStats();
            this.startPolling();
        },
        
        async loadStats() {
            try {
                const response = await fetch('/api/backup/stats');
                const data = await response.json();
                this.stats = data;
            } catch (error) {
                console.error('Erreur lors du chargement des statistiques:', error);
            }
        },
        
        startPolling() {
            setInterval(() => {
                this.loadStats();
            }, 30000); // Actualiser toutes les 30 secondes
        },
        
        formatSize(bytes) {
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            if (bytes === 0) return '0 Bytes';
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            return Math.round(bytes / Math.pow(1024, i) * 100) / 100 + ' ' + sizes[i];
        }
    }
}