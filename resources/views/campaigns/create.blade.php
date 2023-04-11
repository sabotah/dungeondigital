
<div class="container">
    <div class="row">
        <div class="col">
            <form action="/campaigns" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Enter the Name of the Campaign">
                </div>

                <div class="form-group">
                    <label for="game">Game</label>
                    <input type="text" class="form-control" id="game" name="game" aria-describedby="game" placeholder="Enter Role Playing Game type e.g. D&D, Pathfinder, Shadowrun">
                </div>

                <div class="form-group">
                    <label for="rulesversion">Ruleset Version</label>
                    <input type="text" class="form-control" id="rulesversion" name="rulesversion" aria-describedby="rulesversion" placeholder="Enter the version number for the Game Ruleset">
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="creatediscord" name="creatediscord"> 
                    <label class="form-check-label" for="creatediscord">
                        Create Discord Channel Group? (on the DungeonDigital Discord Server)
                    </label>
                </div>

                <div>
                    <button class="btn btn-primary" type="submit">Create Campaign</button>
                </div>
            </form>
        </div>
    </div>
</div>