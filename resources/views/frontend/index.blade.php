<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Distribution</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="container-fluid py-4 bg-light text-center">

    <h2 class="mb-4">Distribute Playing Cards</h2>

    {{-- Get Input --}}
    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mb-4">
        <label for="numPlayers" class="form-label fw-bold">Enter number of players:</label>
        <input type="number" id="numPlayers" min="1" class="form-control w-50 w-md-25 text-center">
        <button onclick="dealCards()" class="btn btn-primary">Distribute</button>
    </div>

    {{-- Output --}}
    <h3 class="mt-4">Results:</h3>
    <pre id="output" class="border p-3 bg-white text-center"></pre>

    <div id="cardImages" class="container mt-3"></div>

    <script>
        // Unicode symbols for suits
        const suitSymbols = {
            'H': '♥',
            'D': '♦',
            'C': '♣',
            'S': '♠'
        };

        function dealCards() {
            let numPlayers = $('#numPlayers').val();
            if (!numPlayers || numPlayers <= 0) {
                alert("Please enter a valid number of players.");
                return;
            }

            $.get("/shuffle?n=" + numPlayers, function(data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    $('#output').text(data.join("\n"));
                    $('#cardImages').empty();

                    data.forEach((line, index) => {
                        let rowDiv = $('<div class="row g-3 justify-content-center"></div>');
                        rowDiv.append(`<h5 class="col-12 text-center fw-bold">Player ${index + 1}:</h5>`);

                        line.split(',').forEach(card => {
                            let suit = card[0];
                            let value = card.substring(2);

                            // Replace "X" with "10"
                            if (value === "X") {
                                value = "10";
                            }

                            // Bootstrap card structure
                            let cardDiv = $('<div>', {
                                class: `col-auto d-flex align-items-center justify-content-center border rounded shadow-sm fw-bold p-3`,
                                text: value + suitSymbols[suit]
                            });

                            // Apply color classes for suits
                            if (suit === 'H' || suit === 'D') {
                                cardDiv.addClass('text-danger bg-white');
                            } else {
                                cardDiv.addClass('text-dark bg-white');
                            }

                            rowDiv.append(cardDiv);
                        });

                        $('#cardImages').append(rowDiv);
                    });
                }
            }, "json").fail(() => {
                alert("An error occurred while fetching the cards.");
            });
        }
    </script>

</body>
</html>
