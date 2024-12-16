    function cargarMantenimiento(tipo) {
        let url = '';
        
        switch(tipo) {
            case 'usuarios':
                url = 'mantenimientos/usuarios.php';  
                break;
            case 'catalogo':
                url = 'mantenimientos/catalogo.php';
                break;
            case 'tipo_entrada':
                url = 'mantenimientos/tipo_entrada.php';
                break;
        }
        
        // Realiza la llamada AJAX
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#contenido').html(response);  // Carga el contenido en el div #contenido
            },
            error: function(xhr, status, error) {
                alert('Hubo un problema al cargar el mantenimiento.');
            }
        });
    }
