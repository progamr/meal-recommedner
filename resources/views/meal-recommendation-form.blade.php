<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>MEAL RECOMMENDER</title>
    <style>
        body {
            display: flex;
            flex: 1;
            background-color: #EEEEEE;
            font-family: sans-serif;
            font-size: 20px;
            color: #222222;
        }
        table {
            display: flex;
            flex: 1;
            background-color: #EEEEEE;
            width: 50%;
            align-items: center;
            justify-content: center;
            border: #222 2px solid;
        }

        td {
            border: #222 2px solid;
        }

        .form-container {
            display: flex;
            flex: 1;
            align-items: center;
            justify-content: center;
            background-color: #80ebff;
            flex-direction: column;
            margin-top: 50px;
        }
    </style>
</head>
    <body>
        <div class="form-container">
            <form action="/find-restaurants-v2" method="post" class="form">
                <label for="meal_name">Meal Name</label>
                <input name="meal_name" type="text"/>
                <input name="latitude" type="hidden" value="30.121892"/>
                <input name="longitude" type="hidden" value="31.250228"/>
                @csrf
                <button type="submit">Find</button>
            </form>

            @if(isset($restaurants) && count($restaurants) > 0)
                <table>
                    <th>Name</th>
                    <th>Rank</th>-
                    @foreach($restaurants as $restaurant)
                        <tr>
                            <td>{{$restaurant['name']}}</td>
                            <td>{{$restaurant['rank']}}</td>
                        </tr>
                    @endforeach
                </table>
            @elseif(isset($restaurants) && count($restaurants) === 0)
                <h3>Sorry, No restaurants found for this meal</h3>
            @endif
        </div>
    </body>
</html>
