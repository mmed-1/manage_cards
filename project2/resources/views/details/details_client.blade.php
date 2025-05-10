<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Client</title>
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #6366f1;
            --text-color: #1f2937;
            --light-gray: #f3f4f6;
            --border-color: #e5e7eb;
            --hover-color: #4338ca;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f9fafb;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        header {
            background-color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        a {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        a:hover {
            background-color: var(--hover-color);
        }
        
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        main > div {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        p {
            color: #4b5563;
            font-size: 0.95rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            text-align: left;
            padding: 1rem;
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tbody tr:hover {
            background-color: var(--light-gray);
        }
        
        /* Search form styles */
        .search-container {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
        }
        
        .form-group {
            flex: 1;
            min-width: 200px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.95rem;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .search-button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .search-button:hover {
            background-color: var(--hover-color);
        }
        
        .reset-button {
            background-color: #9ca3af;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .reset-button:hover {
            background-color: #6b7280;
        }
        
        .no-results {
            text-align: center;
            padding: 2rem;
            display: none;
        }
        
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            th, td {
                min-width: 120px;
            }
            
            .search-form {
                flex-direction: column;
            }
            
            .form-group {
                width: 100%;
            }
            
            .button-group {
                display: flex;
                gap: 0.5rem;
                width: 100%;
            }
            
            .search-button, .reset-button {
                flex: 1;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Informations sur {{ $client->prenom . ' ' . $client->nom }}</h1>
        <a href="{{ route('display.clients')}}">Retour</a>
    </header>
    <main>
        <div>
            <p> 
                La table affiche les informations des cartes SIM associées au client sélectionné, notamment le numéro de la carte SIM, la matriculation, 
                la marque et le type du véhicule lié à chaque carte.
            </p>
        </div>
        
        <!-- Search Form -->
        <div class="search-container">
            <div class="search-form">
                <div class="form-group">
                    <label for="num_carte_sim">Recherche par numéro de carte SIM:</label>
                    <input type="text" id="num_carte_sim" name="num_carte_sim" placeholder="Entrez le numéro de carte SIM">
                </div>
                
                <div class="form-group">
                    <label for="matriculation">Recherche par matriculation:</label>
                    <input type="text" id="matriculation" name="matriculation" placeholder="Entrez la matriculation">
                </div>
                
                <div class="button-group">
                    <button type="button" id="resetButton" class="reset-button">Réinitialiser</button>
                </div>
            </div>
        </div>
        
        <table id="cartesTable">
            <thead>
                <tr>
                    <th>Numero de carte sim</th>
                    <th>Matriculation</th>
                    <th>marque</th>
                    <th>type</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cartes as $carte)
                    <tr>
                        <td>{{ $carte->num_carte_sim }}</td>
                        <td>{{ $carte->vehicule->matriculation ?? '---'}}</td>
                        <td>{{ $carte->vehicule->marque ?? '---' }}</td>
                        <td>{{ $carte->vehicule->type ?? '---' }}</td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="4" style="text-align: center; padding: 2rem;">
                            Aucune Information pour le moment
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- No results message (hidden by default) -->
        <div id="noResults" class="no-results">
            Aucun résultat ne correspond à votre recherche
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get DOM elements
            const numCarteInput = document.getElementById('num_carte_sim');
            const matriculationInput = document.getElementById('matriculation');
            const resetButton = document.getElementById('resetButton');
            const table = document.getElementById('cartesTable');
            const noResults = document.getElementById('noResults');
            const rows = table.querySelectorAll('tbody tr:not(.empty-row)');
            
            // Function to filter table rows
            function filterTable() {
                const numCarteValue = numCarteInput.value.toLowerCase().trim();
                const matriculationValue = matriculationInput.value.toLowerCase().trim();
                
                let visibleCount = 0;
                
                // Loop through all rows and check if they match the search criteria
                rows.forEach(row => {
                    const numCarte = row.cells[0].textContent.toLowerCase();
                    const matriculation = row.cells[1].textContent.toLowerCase();
                    
                    // Show row if both criteria match (or if the input is empty)
                    const numCarteMatch = numCarteValue === '' || numCarte.includes(numCarteValue);
                    const matriculationMatch = matriculationValue === '' || matriculation.includes(matriculationValue);
                    
                    if (numCarteMatch && matriculationMatch) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Show or hide the "no results" message
                if (visibleCount === 0 && rows.length > 0) {
                    table.style.display = 'none';
                    noResults.style.display = 'block';
                } else {
                    table.style.display = '';
                    noResults.style.display = 'none';
                }
            }
            
            // Function to reset the search
            function resetSearch() {
                numCarteInput.value = '';
                matriculationInput.value = '';
                
                // Show all rows
                rows.forEach(row => {
                    row.style.display = '';
                });
                
                // Hide the "no results" message
                table.style.display = '';
                noResults.style.display = 'none';
                
                // Focus on the first input
                numCarteInput.focus();
            }
            
            // Add event listeners
            numCarteInput.addEventListener('input', filterTable);
            matriculationInput.addEventListener('input', filterTable);
            resetButton.addEventListener('click', resetSearch);
            
            // Initialize the table (in case there are default values)
            filterTable();
        });
    </script>
</body>
</html>