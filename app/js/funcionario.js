function formatPercentage(input) {
    let value = input.value.replace(',', '.').replace(/[^0-9.]/g, ''); // Substitui vírgulas por pontos e remove caracteres inválidos
    
    if (value !== '') {
        value = parseFloat(value);

        // Verifica se o valor ultrapassa 100
        if (value > 100) {
            alert('A porcentagem não pode ultrapassar 100.');
            value = 100; // Ajusta automaticamente para o máximo permitido
        }
    }

    // Atualiza o valor do campo com vírgula como separador decimal
    input.value = value ? value.toString().replace('.', ',') : '';
}

function formatPhone(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 0) value = '(' + value;
    if (value.length > 2) value = value.slice(0, 3) + ') ' + value.slice(3);
    if (value.length > 9) value = value.slice(0, 10) + '-' + value.slice(10);
    input.value = value.slice(0, 15);
}
