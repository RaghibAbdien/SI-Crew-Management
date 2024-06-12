    document.getElementById('tgl_mcu').addEventListener('change', function() {
        var tglMcu = this.value;
        document.getElementById('expired_mcu').setAttribute('min', tglMcu);
    });

    document.getElementById('awal_kontrak').addEventListener('change', function() {
        var tglKontrak = this.value;
        document.getElementById('berakhir_kontrak').setAttribute('min', tglKontrak);
    });

    document.addEventListener('DOMContentLoaded', (event) => {
        const tglMcuInput = document.getElementById('tgl_mcu');
        const expiredMcuInput = document.getElementById('expired_mcu');
        const tglKontrakInput = document.getElementById('awal_kontrak');
        const expiredKontrakInput = document.getElementById('berakhir_kontrak');
        
        // Disable expired_mcu input initially
        expiredMcuInput.disabled = true;
        
        tglMcuInput.addEventListener('input', function() {
            if (this.value) {
                // Enable expired_mcu input if tgl_mcu is filled
                expiredMcuInput.disabled = false;
            } else {
                // Disable expired_mcu input if tgl_mcu is empty
                expiredMcuInput.disabled = true;
                expiredMcuInput.value = ''; // Clear the value of expired_mcu
            }
        });

        // Untuk Tanggal Kontrak
        expiredKontrakInput.disabled = true;
        
        tglKontrakInput.addEventListener('input', function() {
            if (this.value) {
                
                expiredKontrakInput.disabled = false;
            } else {
                
                expiredKontrakInput.disabled = true;
                expiredKontrakInput.value = ''; 
            }
        });
    });