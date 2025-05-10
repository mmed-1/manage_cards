<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'utilisateur</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --dark: #2b2d42;
            --light: #f8f9fa;
            --gray: #e9ecef;
            --gray-dark: #adb5bd;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1140px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
        }

        h1 {
            text-align: center;
            color: var(--dark);
            margin-bottom: 30px;
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            border-radius: 2px;
        }

        h2 {
            color: var(--dark);
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        h2::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 24px;
            background: var(--primary);
            margin-right: 12px;
            border-radius: 4px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .card {
            background: white;
            padding: 25px 20px;
            border-radius: var(--radius);
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .card h3 {
            margin-bottom: 15px;
            color: var(--dark);
            font-weight: 500;
            font-size: 1rem;
        }

        .card p {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary);
        }

        .section {
            margin-top: 40px;
            background: white;
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-radius: var(--radius);
            overflow: hidden;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
        }

        table th {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        table tr {
            background-color: white;
            border-bottom: 1px solid var(--gray);
        }

        table tr:last-child {
            border-bottom: none;
        }

        table tr:nth-child(even) {
            background-color: rgba(67, 97, 238, 0.05);
        }

        table tr:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .stats {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .card {
                padding: 15px;
            }
            
            .card p {
                font-size: 22px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Détails de l'utilisateur {{ $data['name'] }}</h1>

        <div class="stats">
            <div class="card">
                <h3>Cartes SIM</h3>
                <p>{{ $data['countSim'] }}</p>
            </div>
            <div class="card">
                <h3>Cartes BLR</h3>
                <p>{{ $data['countBlr'] }}</p>
            </div>
            <div class="card">
                <h3>Recharges SIM</h3>
                <p>{{ $data['simNums'] }}</p>
            </div>
            <div class="card">
                <h3>Recharges BLR</h3>
                <p>{{ $data['blrNums'] }}</p>
            </div>
        </div>

        <div class="section">
            <h2>Liste des cartes SIM</h2>
            <table>
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Opérateur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['cartesSim'] as $sim)
                        <tr>
                            <td>{{ $sim->num_carte_sim }}</td>
                            <td>{{ $sim->operateur ?? '---' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Liste des cartes BLR</h2>
            <table>
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Opérateur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['cartesBlr'] as $blr)
                        <tr>
                            <td>{{ $blr->num_carte }}</td>
                            <td>{{ $blr->operateur ?? '---' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Recharges SIM</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['rechargesSim'] as $recharge)
                        <tr>
                            <td>{{ $recharge->date_recharge }}</td>
                            <td>{{ $recharge->montant ?? '---' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Recharges BLR</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['rechargesBlr'] as $recharge)
                        <tr>
                            <td>{{ $recharge->date_recharge }}</td>
                            <td>{{ $recharge->montant ?? '---' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>