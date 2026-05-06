<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\PlayerStat;
use App\Models\Team;
use Illuminate\Database\Seeder;

class PlayerStatsSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            // ATLANTA HAWKS
            ['team' => 'ATL', 'first' => 'Trae', 'last' => 'Young', 'pos' => 'PG', 'gp' => 55, 'pts' => 25.7, 'reb' => 2.8, 'ast' => 10.8, 'stl' => 1.1, 'blk' => 0.2, 'fg' => 0.430, 'fg3' => 0.343, 'ft' => 0.868, 'min' => 34.0],
            ['team' => 'ATL', 'first' => 'Dejounte', 'last' => 'Murray', 'pos' => 'PG', 'gp' => 37, 'pts' => 22.5, 'reb' => 5.3, 'ast' => 6.1, 'stl' => 1.6, 'blk' => 0.3, 'fg' => 0.462, 'fg3' => 0.358, 'ft' => 0.753, 'min' => 35.2],
            ['team' => 'ATL', 'first' => 'Bogdan', 'last' => 'Bogdanovic', 'pos' => 'SG', 'gp' => 52, 'pts' => 14.2, 'reb' => 3.1, 'ast' => 3.0, 'stl' => 0.8, 'blk' => 0.2, 'fg' => 0.441, 'fg3' => 0.378, 'ft' => 0.821, 'min' => 28.5],
            ['team' => 'ATL', 'first' => 'Clint', 'last' => 'Capela', 'pos' => 'C', 'gp' => 52, 'pts' => 10.7, 'reb' => 10.5, 'ast' => 1.0, 'stl' => 0.7, 'blk' => 1.5, 'fg' => 0.601, 'fg3' => 0.000, 'ft' => 0.612, 'min' => 27.5],
            ['team' => 'ATL', 'first' => 'Saddiq', 'last' => 'Bey', 'pos' => 'SF', 'gp' => 60, 'pts' => 11.2, 'reb' => 4.1, 'ast' => 1.8, 'stl' => 0.7, 'blk' => 0.3, 'fg' => 0.431, 'fg3' => 0.352, 'ft' => 0.780, 'min' => 25.0],
            ['team' => 'ATL', 'first' => 'De\'Andre', 'last' => 'Hunter', 'pos' => 'SF', 'gp' => 60, 'pts' => 13.0, 'reb' => 3.8, 'ast' => 1.9, 'stl' => 0.9, 'blk' => 0.5, 'fg' => 0.472, 'fg3' => 0.340, 'ft' => 0.731, 'min' => 27.0],
            ['team' => 'ATL', 'first' => 'Onyeka', 'last' => 'Okongwu', 'pos' => 'C', 'gp' => 58, 'pts' => 9.8, 'reb' => 7.2, 'ast' => 1.5, 'stl' => 0.8, 'blk' => 1.2, 'fg' => 0.581, 'fg3' => 0.000, 'ft' => 0.672, 'min' => 22.5],

            // BOSTON CELTICS
            ['team' => 'BOS', 'first' => 'Jayson', 'last' => 'Tatum', 'pos' => 'SF', 'gp' => 74, 'pts' => 26.9, 'reb' => 8.1, 'ast' => 4.9, 'stl' => 1.0, 'blk' => 0.6, 'fg' => 0.471, 'fg3' => 0.371, 'ft' => 0.812, 'min' => 35.5],
            ['team' => 'BOS', 'first' => 'Jaylen', 'last' => 'Brown', 'pos' => 'SG', 'gp' => 70, 'pts' => 23.0, 'reb' => 5.5, 'ast' => 3.6, 'stl' => 1.1, 'blk' => 0.5, 'fg' => 0.492, 'fg3' => 0.354, 'ft' => 0.723, 'min' => 33.1],
            ['team' => 'BOS', 'first' => 'Kristaps', 'last' => 'Porzingis', 'pos' => 'C', 'gp' => 57, 'pts' => 20.1, 'reb' => 7.2, 'ast' => 2.0, 'stl' => 0.7, 'blk' => 1.9, 'fg' => 0.511, 'fg3' => 0.376, 'ft' => 0.857, 'min' => 29.1],
            ['team' => 'BOS', 'first' => 'Jrue', 'last' => 'Holiday', 'pos' => 'PG', 'gp' => 68, 'pts' => 12.5, 'reb' => 5.4, 'ast' => 4.8, 'stl' => 1.6, 'blk' => 0.5, 'fg' => 0.471, 'fg3' => 0.373, 'ft' => 0.731, 'min' => 31.5],
            ['team' => 'BOS', 'first' => 'Al', 'last' => 'Horford', 'pos' => 'C', 'gp' => 65, 'pts' => 9.1, 'reb' => 6.8, 'ast' => 2.9, 'stl' => 0.6, 'blk' => 1.1, 'fg' => 0.512, 'fg3' => 0.379, 'ft' => 0.791, 'min' => 28.5],
            ['team' => 'BOS', 'first' => 'Derrick', 'last' => 'White', 'pos' => 'SG', 'gp' => 73, 'pts' => 15.2, 'reb' => 4.2, 'ast' => 5.2, 'stl' => 1.0, 'blk' => 1.2, 'fg' => 0.462, 'fg3' => 0.398, 'ft' => 0.872, 'min' => 30.5],
            ['team' => 'BOS', 'first' => 'Payton', 'last' => 'Pritchard', 'pos' => 'PG', 'gp' => 74, 'pts' => 9.8, 'reb' => 2.5, 'ast' => 2.5, 'stl' => 0.5, 'blk' => 0.2, 'fg' => 0.448, 'fg3' => 0.412, 'ft' => 0.845, 'min' => 20.5],

            // BROOKLYN NETS
            ['team' => 'BKN', 'first' => 'Mikal', 'last' => 'Bridges', 'pos' => 'SF', 'gp' => 82, 'pts' => 19.6, 'reb' => 4.5, 'ast' => 3.7, 'stl' => 0.9, 'blk' => 0.5, 'fg' => 0.456, 'fg3' => 0.376, 'ft' => 0.831, 'min' => 35.8],
            ['team' => 'BKN', 'first' => 'Cameron', 'last' => 'Thomas', 'pos' => 'SG', 'gp' => 47, 'pts' => 22.5, 'reb' => 2.8, 'ast' => 2.8, 'stl' => 0.7, 'blk' => 0.3, 'fg' => 0.449, 'fg3' => 0.352, 'ft' => 0.876, 'min' => 32.1],
            ['team' => 'BKN', 'first' => 'Nic', 'last' => 'Claxton', 'pos' => 'C', 'gp' => 60, 'pts' => 11.8, 'reb' => 9.4, 'ast' => 2.8, 'stl' => 0.8, 'blk' => 2.0, 'fg' => 0.601, 'fg3' => 0.000, 'ft' => 0.622, 'min' => 29.5],
            ['team' => 'BKN', 'first' => 'Ben', 'last' => 'Simmons', 'pos' => 'PG', 'gp' => 18, 'pts' => 6.1, 'reb' => 5.7, 'ast' => 4.7, 'stl' => 1.0, 'blk' => 0.5, 'fg' => 0.541, 'fg3' => 0.000, 'ft' => 0.512, 'min' => 20.0],
            ['team' => 'BKN', 'first' => 'Spencer', 'last' => 'Dinwiddie', 'pos' => 'PG', 'gp' => 55, 'pts' => 13.5, 'reb' => 2.8, 'ast' => 4.5, 'stl' => 0.7, 'blk' => 0.2, 'fg' => 0.435, 'fg3' => 0.341, 'ft' => 0.821, 'min' => 26.5],
            ['team' => 'BKN', 'first' => 'Dorian', 'last' => 'Finney-Smith', 'pos' => 'SF', 'gp' => 65, 'pts' => 9.2, 'reb' => 4.1, 'ast' => 1.8, 'stl' => 1.0, 'blk' => 0.4, 'fg' => 0.421, 'fg3' => 0.371, 'ft' => 0.752, 'min' => 27.5],
            ['team' => 'BKN', 'first' => 'Dennis', 'last' => 'Schroder', 'pos' => 'PG', 'gp' => 70, 'pts' => 14.2, 'reb' => 3.1, 'ast' => 5.5, 'stl' => 1.0, 'blk' => 0.2, 'fg' => 0.442, 'fg3' => 0.358, 'ft' => 0.812, 'min' => 28.5],

            // CHARLOTTE HORNETS
            ['team' => 'CHA', 'first' => 'LaMelo', 'last' => 'Ball', 'pos' => 'PG', 'gp' => 22, 'pts' => 23.9, 'reb' => 4.9, 'ast' => 8.7, 'stl' => 1.5, 'blk' => 0.4, 'fg' => 0.431, 'fg3' => 0.343, 'ft' => 0.796, 'min' => 33.2],
            ['team' => 'CHA', 'first' => 'Miles', 'last' => 'Bridges', 'pos' => 'SF', 'gp' => 79, 'pts' => 21.0, 'reb' => 6.6, 'ast' => 3.6, 'stl' => 1.1, 'blk' => 0.5, 'fg' => 0.464, 'fg3' => 0.329, 'ft' => 0.751, 'min' => 34.5],
            ['team' => 'CHA', 'first' => 'Brandon', 'last' => 'Miller', 'pos' => 'SF', 'gp' => 73, 'pts' => 17.3, 'reb' => 4.3, 'ast' => 2.6, 'stl' => 0.9, 'blk' => 0.6, 'fg' => 0.444, 'fg3' => 0.376, 'ft' => 0.826, 'min' => 32.0],
            ['team' => 'CHA', 'first' => 'Terry', 'last' => 'Rozier', 'pos' => 'SG', 'gp' => 29, 'pts' => 23.1, 'reb' => 4.2, 'ast' => 5.1, 'stl' => 1.2, 'blk' => 0.3, 'fg' => 0.451, 'fg3' => 0.381, 'ft' => 0.841, 'min' => 34.0],
            ['team' => 'CHA', 'first' => 'Mark', 'last' => 'Williams', 'pos' => 'C', 'gp' => 30, 'pts' => 11.5, 'reb' => 9.5, 'ast' => 1.2, 'stl' => 0.5, 'blk' => 1.8, 'fg' => 0.621, 'fg3' => 0.000, 'ft' => 0.672, 'min' => 25.5],
            ['team' => 'CHA', 'first' => 'Grant', 'last' => 'Williams', 'pos' => 'PF', 'gp' => 68, 'pts' => 9.8, 'reb' => 4.2, 'ast' => 1.9, 'stl' => 0.8, 'blk' => 0.5, 'fg' => 0.432, 'fg3' => 0.361, 'ft' => 0.782, 'min' => 24.5],
            ['team' => 'CHA', 'first' => 'Nick', 'last' => 'Richards', 'pos' => 'C', 'gp' => 65, 'pts' => 8.5, 'reb' => 7.8, 'ast' => 0.8, 'stl' => 0.5, 'blk' => 1.2, 'fg' => 0.598, 'fg3' => 0.000, 'ft' => 0.612, 'min' => 20.5],

            // CHICAGO BULLS
            ['team' => 'CHI', 'first' => 'DeMar', 'last' => 'DeRozan', 'pos' => 'SF', 'gp' => 63, 'pts' => 24.0, 'reb' => 4.4, 'ast' => 5.3, 'stl' => 0.9, 'blk' => 0.3, 'fg' => 0.506, 'fg3' => 0.310, 'ft' => 0.843, 'min' => 34.1],
            ['team' => 'CHI', 'first' => 'Zach', 'last' => 'LaVine', 'pos' => 'SG', 'gp' => 25, 'pts' => 19.5, 'reb' => 4.3, 'ast' => 3.9, 'stl' => 0.8, 'blk' => 0.4, 'fg' => 0.456, 'fg3' => 0.358, 'ft' => 0.791, 'min' => 30.2],
            ['team' => 'CHI', 'first' => 'Nikola', 'last' => 'Vucevic', 'pos' => 'C', 'gp' => 73, 'pts' => 17.8, 'reb' => 10.8, 'ast' => 3.3, 'stl' => 0.8, 'blk' => 0.9, 'fg' => 0.497, 'fg3' => 0.333, 'ft' => 0.773, 'min' => 32.0],
            ['team' => 'CHI', 'first' => 'Coby', 'last' => 'White', 'pos' => 'PG', 'gp' => 74, 'pts' => 19.1, 'reb' => 4.5, 'ast' => 5.1, 'stl' => 0.9, 'blk' => 0.3, 'fg' => 0.461, 'fg3' => 0.398, 'ft' => 0.861, 'min' => 32.5],
            ['team' => 'CHI', 'first' => 'Patrick', 'last' => 'Williams', 'pos' => 'PF', 'gp' => 68, 'pts' => 11.4, 'reb' => 4.2, 'ast' => 2.1, 'stl' => 0.8, 'blk' => 0.5, 'fg' => 0.471, 'fg3' => 0.351, 'ft' => 0.741, 'min' => 27.5],
            ['team' => 'CHI', 'first' => 'Andre', 'last' => 'Drummond', 'pos' => 'C', 'gp' => 55, 'pts' => 8.2, 'reb' => 9.5, 'ast' => 1.1, 'stl' => 0.6, 'blk' => 0.9, 'fg' => 0.571, 'fg3' => 0.000, 'ft' => 0.521, 'min' => 20.5],
            ['team' => 'CHI', 'first' => 'Jevon', 'last' => 'Carter', 'pos' => 'SG', 'gp' => 60, 'pts' => 7.5, 'reb' => 2.1, 'ast' => 2.5, 'stl' => 1.1, 'blk' => 0.2, 'fg' => 0.421, 'fg3' => 0.371, 'ft' => 0.821, 'min' => 18.5],

            // CLEVELAND CAVALIERS
            ['team' => 'CLE', 'first' => 'Donovan', 'last' => 'Mitchell', 'pos' => 'SG', 'gp' => 55, 'pts' => 26.6, 'reb' => 5.1, 'ast' => 6.1, 'stl' => 1.7, 'blk' => 0.5, 'fg' => 0.464, 'fg3' => 0.368, 'ft' => 0.876, 'min' => 35.0],
            ['team' => 'CLE', 'first' => 'Darius', 'last' => 'Garland', 'pos' => 'PG', 'gp' => 51, 'pts' => 20.6, 'reb' => 3.0, 'ast' => 6.7, 'stl' => 1.1, 'blk' => 0.2, 'fg' => 0.453, 'fg3' => 0.373, 'ft' => 0.883, 'min' => 33.2],
            ['team' => 'CLE', 'first' => 'Evan', 'last' => 'Mobley', 'pos' => 'C', 'gp' => 76, 'pts' => 15.7, 'reb' => 9.4, 'ast' => 2.9, 'stl' => 1.2, 'blk' => 1.7, 'fg' => 0.553, 'fg3' => 0.283, 'ft' => 0.702, 'min' => 33.5],
            ['team' => 'CLE', 'first' => 'Jarrett', 'last' => 'Allen', 'pos' => 'C', 'gp' => 67, 'pts' => 13.7, 'reb' => 10.5, 'ast' => 1.8, 'stl' => 0.8, 'blk' => 1.1, 'fg' => 0.621, 'fg3' => 0.000, 'ft' => 0.712, 'min' => 28.5],
            ['team' => 'CLE', 'first' => 'Max', 'last' => 'Strus', 'pos' => 'SG', 'gp' => 72, 'pts' => 12.2, 'reb' => 4.5, 'ast' => 2.5, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.421, 'fg3' => 0.381, 'ft' => 0.821, 'min' => 28.0],
            ['team' => 'CLE', 'first' => 'Caris', 'last' => 'LeVert', 'pos' => 'SG', 'gp' => 55, 'pts' => 11.5, 'reb' => 3.2, 'ast' => 3.5, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.441, 'fg3' => 0.351, 'ft' => 0.801, 'min' => 24.5],
            ['team' => 'CLE', 'first' => 'Georges', 'last' => 'Niang', 'pos' => 'PF', 'gp' => 65, 'pts' => 8.5, 'reb' => 3.5, 'ast' => 1.5, 'stl' => 0.5, 'blk' => 0.2, 'fg' => 0.442, 'fg3' => 0.401, 'ft' => 0.871, 'min' => 20.5],

            // DALLAS MAVERICKS
            ['team' => 'DAL', 'first' => 'Luka', 'last' => 'Doncic', 'pos' => 'PG', 'gp' => 70, 'pts' => 33.9, 'reb' => 9.2, 'ast' => 9.8, 'stl' => 1.4, 'blk' => 0.5, 'fg' => 0.487, 'fg3' => 0.382, 'ft' => 0.786, 'min' => 37.5],
            ['team' => 'DAL', 'first' => 'Kyrie', 'last' => 'Irving', 'pos' => 'PG', 'gp' => 74, 'pts' => 25.6, 'reb' => 5.0, 'ast' => 5.2, 'stl' => 1.3, 'blk' => 0.5, 'fg' => 0.491, 'fg3' => 0.413, 'ft' => 0.876, 'min' => 35.1],
            ['team' => 'DAL', 'first' => 'PJ', 'last' => 'Washington', 'pos' => 'PF', 'gp' => 77, 'pts' => 12.9, 'reb' => 5.6, 'ast' => 2.2, 'stl' => 0.9, 'blk' => 0.7, 'fg' => 0.493, 'fg3' => 0.382, 'ft' => 0.731, 'min' => 28.5],
            ['team' => 'DAL', 'first' => 'Derrick', 'last' => 'Jones Jr.', 'pos' => 'SF', 'gp' => 74, 'pts' => 8.5, 'reb' => 4.8, 'ast' => 1.8, 'stl' => 1.2, 'blk' => 0.8, 'fg' => 0.521, 'fg3' => 0.341, 'ft' => 0.671, 'min' => 25.5],
            ['team' => 'DAL', 'first' => 'Tim', 'last' => 'Hardaway Jr.', 'pos' => 'SG', 'gp' => 55, 'pts' => 11.8, 'reb' => 2.5, 'ast' => 1.8, 'stl' => 0.6, 'blk' => 0.2, 'fg' => 0.441, 'fg3' => 0.381, 'ft' => 0.841, 'min' => 23.5],
            ['team' => 'DAL', 'first' => 'Daniel', 'last' => 'Gafford', 'pos' => 'C', 'gp' => 75, 'pts' => 11.2, 'reb' => 6.5, 'ast' => 1.2, 'stl' => 0.8, 'blk' => 2.1, 'fg' => 0.711, 'fg3' => 0.000, 'ft' => 0.621, 'min' => 22.5],
            ['team' => 'DAL', 'first' => 'Josh', 'last' => 'Green', 'pos' => 'SG', 'gp' => 72, 'pts' => 8.2, 'reb' => 3.5, 'ast' => 2.1, 'stl' => 1.0, 'blk' => 0.3, 'fg' => 0.461, 'fg3' => 0.361, 'ft' => 0.721, 'min' => 22.0],

            // DENVER NUGGETS
            ['team' => 'DEN', 'first' => 'Nikola', 'last' => 'Jokic', 'pos' => 'C', 'gp' => 79, 'pts' => 26.4, 'reb' => 12.4, 'ast' => 9.0, 'stl' => 1.4, 'blk' => 0.9, 'fg' => 0.583, 'fg3' => 0.359, 'ft' => 0.817, 'min' => 34.6],
            ['team' => 'DEN', 'first' => 'Jamal', 'last' => 'Murray', 'pos' => 'PG', 'gp' => 76, 'pts' => 21.2, 'reb' => 4.2, 'ast' => 6.5, 'stl' => 0.9, 'blk' => 0.3, 'fg' => 0.482, 'fg3' => 0.406, 'ft' => 0.845, 'min' => 33.7],
            ['team' => 'DEN', 'first' => 'Michael', 'last' => 'Porter Jr.', 'pos' => 'SF', 'gp' => 60, 'pts' => 17.0, 'reb' => 7.0, 'ast' => 1.5, 'stl' => 0.7, 'blk' => 0.5, 'fg' => 0.508, 'fg3' => 0.408, 'ft' => 0.821, 'min' => 30.5],
            ['team' => 'DEN', 'first' => 'Aaron', 'last' => 'Gordon', 'pos' => 'PF', 'gp' => 75, 'pts' => 13.9, 'reb' => 6.5, 'ast' => 3.5, 'stl' => 0.9, 'blk' => 0.6, 'fg' => 0.551, 'fg3' => 0.321, 'ft' => 0.681, 'min' => 29.5],
            ['team' => 'DEN', 'first' => 'Kentavious', 'last' => 'Caldwell-Pope', 'pos' => 'SG', 'gp' => 76, 'pts' => 10.8, 'reb' => 3.2, 'ast' => 2.1, 'stl' => 1.0, 'blk' => 0.3, 'fg' => 0.451, 'fg3' => 0.411, 'ft' => 0.871, 'min' => 27.5],
            ['team' => 'DEN', 'first' => 'Reggie', 'last' => 'Jackson', 'pos' => 'PG', 'gp' => 60, 'pts' => 9.2, 'reb' => 2.5, 'ast' => 3.8, 'stl' => 0.7, 'blk' => 0.2, 'fg' => 0.431, 'fg3' => 0.371, 'ft' => 0.841, 'min' => 20.5],
            ['team' => 'DEN', 'first' => 'Peyton', 'last' => 'Watson', 'pos' => 'SF', 'gp' => 55, 'pts' => 6.5, 'reb' => 3.8, 'ast' => 0.9, 'stl' => 0.7, 'blk' => 0.6, 'fg' => 0.461, 'fg3' => 0.341, 'ft' => 0.711, 'min' => 18.5],

            // DETROIT PISTONS
            ['team' => 'DET', 'first' => 'Cade', 'last' => 'Cunningham', 'pos' => 'PG', 'gp' => 62, 'pts' => 22.7, 'reb' => 4.4, 'ast' => 7.9, 'stl' => 1.1, 'blk' => 0.5, 'fg' => 0.436, 'fg3' => 0.330, 'ft' => 0.831, 'min' => 35.1],
            ['team' => 'DET', 'first' => 'Bojan', 'last' => 'Bogdanovic', 'pos' => 'SF', 'gp' => 54, 'pts' => 14.0, 'reb' => 2.8, 'ast' => 1.8, 'stl' => 0.6, 'blk' => 0.2, 'fg' => 0.447, 'fg3' => 0.386, 'ft' => 0.879, 'min' => 26.3],
            ['team' => 'DET', 'first' => 'Jalen', 'last' => 'Duren', 'pos' => 'C', 'gp' => 58, 'pts' => 13.8, 'reb' => 12.9, 'ast' => 1.8, 'stl' => 0.7, 'blk' => 1.1, 'fg' => 0.579, 'fg3' => 0.000, 'ft' => 0.592, 'min' => 28.9],
            ['team' => 'DET', 'first' => 'Ausar', 'last' => 'Thompson', 'pos' => 'SF', 'gp' => 55, 'pts' => 12.5, 'reb' => 6.2, 'ast' => 2.5, 'stl' => 1.5, 'blk' => 0.8, 'fg' => 0.501, 'fg3' => 0.291, 'ft' => 0.631, 'min' => 27.5],
            ['team' => 'DET', 'first' => 'Alec', 'last' => 'Burks', 'pos' => 'SG', 'gp' => 60, 'pts' => 11.2, 'reb' => 3.1, 'ast' => 2.5, 'stl' => 0.7, 'blk' => 0.2, 'fg' => 0.431, 'fg3' => 0.371, 'ft' => 0.821, 'min' => 23.5],
            ['team' => 'DET', 'first' => 'Isaiah', 'last' => 'Stewart', 'pos' => 'PF', 'gp' => 68, 'pts' => 10.5, 'reb' => 7.2, 'ast' => 2.1, 'stl' => 0.8, 'blk' => 0.9, 'fg' => 0.471, 'fg3' => 0.311, 'ft' => 0.701, 'min' => 26.5],
            ['team' => 'DET', 'first' => 'Killian', 'last' => 'Hayes', 'pos' => 'PG', 'gp' => 45, 'pts' => 7.8, 'reb' => 3.5, 'ast' => 4.2, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.401, 'fg3' => 0.321, 'ft' => 0.761, 'min' => 20.5],

            // GOLDEN STATE WARRIORS
            ['team' => 'GSW', 'first' => 'Stephen', 'last' => 'Curry', 'pos' => 'PG', 'gp' => 74, 'pts' => 26.4, 'reb' => 4.5, 'ast' => 5.1, 'stl' => 0.7, 'blk' => 0.4, 'fg' => 0.452, 'fg3' => 0.408, 'ft' => 0.923, 'min' => 32.7],
            ['team' => 'GSW', 'first' => 'Klay', 'last' => 'Thompson', 'pos' => 'SG', 'gp' => 68, 'pts' => 17.9, 'reb' => 3.3, 'ast' => 2.3, 'stl' => 0.7, 'blk' => 0.5, 'fg' => 0.438, 'fg3' => 0.388, 'ft' => 0.840, 'min' => 30.2],
            ['team' => 'GSW', 'first' => 'Draymond', 'last' => 'Green', 'pos' => 'PF', 'gp' => 55, 'pts' => 9.0, 'reb' => 7.2, 'ast' => 6.0, 'stl' => 1.0, 'blk' => 0.8, 'fg' => 0.490, 'fg3' => 0.310, 'ft' => 0.640, 'min' => 27.5],
            ['team' => 'GSW', 'first' => 'Andrew', 'last' => 'Wiggins', 'pos' => 'SF', 'gp' => 60, 'pts' => 13.5, 'reb' => 4.8, 'ast' => 2.1, 'stl' => 0.9, 'blk' => 0.6, 'fg' => 0.451, 'fg3' => 0.361, 'ft' => 0.711, 'min' => 28.5],
            ['team' => 'GSW', 'first' => 'Chris', 'last' => 'Paul', 'pos' => 'PG', 'gp' => 58, 'pts' => 9.4, 'reb' => 4.0, 'ast' => 6.8, 'stl' => 1.3, 'blk' => 0.2, 'fg' => 0.442, 'fg3' => 0.371, 'ft' => 0.836, 'min' => 27.5],
            ['team' => 'GSW', 'first' => 'Jonathan', 'last' => 'Kuminga', 'pos' => 'SF', 'gp' => 69, 'pts' => 16.1, 'reb' => 4.8, 'ast' => 2.2, 'stl' => 0.8, 'blk' => 0.5, 'fg' => 0.521, 'fg3' => 0.301, 'ft' => 0.731, 'min' => 26.5],
            ['team' => 'GSW', 'first' => 'Brandin', 'last' => 'Podziemski', 'pos' => 'SG', 'gp' => 76, 'pts' => 9.2, 'reb' => 5.5, 'ast' => 3.2, 'stl' => 1.0, 'blk' => 0.3, 'fg' => 0.441, 'fg3' => 0.361, 'ft' => 0.771, 'min' => 25.5],

            // HOUSTON ROCKETS
            ['team' => 'HOU', 'first' => 'Alperen', 'last' => 'Sengun', 'pos' => 'C', 'gp' => 72, 'pts' => 21.1, 'reb' => 9.3, 'ast' => 5.0, 'stl' => 0.9, 'blk' => 1.3, 'fg' => 0.556, 'fg3' => 0.238, 'ft' => 0.736, 'min' => 31.5],
            ['team' => 'HOU', 'first' => 'Jalen', 'last' => 'Green', 'pos' => 'SG', 'gp' => 76, 'pts' => 19.5, 'reb' => 4.2, 'ast' => 4.0, 'stl' => 1.2, 'blk' => 0.5, 'fg' => 0.428, 'fg3' => 0.329, 'ft' => 0.793, 'min' => 32.3],
            ['team' => 'HOU', 'first' => 'Fred', 'last' => 'VanVleet', 'pos' => 'PG', 'gp' => 67, 'pts' => 14.9, 'reb' => 3.6, 'ast' => 6.8, 'stl' => 1.5, 'blk' => 0.3, 'fg' => 0.401, 'fg3' => 0.345, 'ft' => 0.844, 'min' => 33.0],
            ['team' => 'HOU', 'first' => 'Dillon', 'last' => 'Brooks', 'pos' => 'SF', 'gp' => 75, 'pts' => 12.8, 'reb' => 3.5, 'ast' => 2.2, 'stl' => 1.2, 'blk' => 0.4, 'fg' => 0.411, 'fg3' => 0.341, 'ft' => 0.751, 'min' => 27.5],
            ['team' => 'HOU', 'first' => 'Jabari', 'last' => 'Smith Jr.', 'pos' => 'PF', 'gp' => 65, 'pts' => 11.2, 'reb' => 6.5, 'ast' => 1.5, 'stl' => 0.7, 'blk' => 0.8, 'fg' => 0.461, 'fg3' => 0.351, 'ft' => 0.731, 'min' => 26.5],
            ['team' => 'HOU', 'first' => 'Amen', 'last' => 'Thompson', 'pos' => 'SF', 'gp' => 70, 'pts' => 9.5, 'reb' => 7.2, 'ast' => 2.8, 'stl' => 1.2, 'blk' => 0.6, 'fg' => 0.521, 'fg3' => 0.201, 'ft' => 0.591, 'min' => 24.5],
            ['team' => 'HOU', 'first' => 'Steven', 'last' => 'Adams', 'pos' => 'C', 'gp' => 40, 'pts' => 5.5, 'reb' => 8.8, 'ast' => 1.5, 'stl' => 0.6, 'blk' => 0.5, 'fg' => 0.581, 'fg3' => 0.000, 'ft' => 0.491, 'min' => 18.5],

            // INDIANA PACERS
            ['team' => 'IND', 'first' => 'Tyrese', 'last' => 'Haliburton', 'pos' => 'PG', 'gp' => 69, 'pts' => 20.1, 'reb' => 3.9, 'ast' => 10.9, 'stl' => 1.2, 'blk' => 0.3, 'fg' => 0.474, 'fg3' => 0.403, 'ft' => 0.878, 'min' => 33.4],
            ['team' => 'IND', 'first' => 'Pascal', 'last' => 'Siakam', 'pos' => 'PF', 'gp' => 58, 'pts' => 21.3, 'reb' => 7.8, 'ast' => 3.7, 'stl' => 0.9, 'blk' => 0.6, 'fg' => 0.530, 'fg3' => 0.333, 'ft' => 0.741, 'min' => 34.5],
            ['team' => 'IND', 'first' => 'Myles', 'last' => 'Turner', 'pos' => 'C', 'gp' => 73, 'pts' => 13.9, 'reb' => 6.5, 'ast' => 1.5, 'stl' => 0.7, 'blk' => 2.4, 'fg' => 0.524, 'fg3' => 0.365, 'ft' => 0.815, 'min' => 28.5],
            ['team' => 'IND', 'first' => 'Andrew', 'last' => 'Nembhard', 'pos' => 'PG', 'gp' => 75, 'pts' => 12.5, 'reb' => 3.8, 'ast' => 5.5, 'stl' => 1.1, 'blk' => 0.3, 'fg' => 0.481, 'fg3' => 0.391, 'ft' => 0.831, 'min' => 29.5],
            ['team' => 'IND', 'first' => 'Bennedict', 'last' => 'Mathurin', 'pos' => 'SG', 'gp' => 62, 'pts' => 13.8, 'reb' => 4.2, 'ast' => 1.8, 'stl' => 0.7, 'blk' => 0.3, 'fg' => 0.441, 'fg3' => 0.351, 'ft' => 0.801, 'min' => 25.5],
            ['team' => 'IND', 'first' => 'Obi', 'last' => 'Toppin', 'pos' => 'PF', 'gp' => 65, 'pts' => 10.2, 'reb' => 4.5, 'ast' => 1.5, 'stl' => 0.6, 'blk' => 0.4, 'fg' => 0.531, 'fg3' => 0.361, 'ft' => 0.721, 'min' => 22.5],
            ['team' => 'IND', 'first' => 'T.J.', 'last' => 'McConnell', 'pos' => 'PG', 'gp' => 70, 'pts' => 8.5, 'reb' => 2.8, 'ast' => 5.2, 'stl' => 1.5, 'blk' => 0.2, 'fg' => 0.551, 'fg3' => 0.311, 'ft' => 0.751, 'min' => 20.5],

            // LA CLIPPERS
            ['team' => 'LAC', 'first' => 'Kawhi', 'last' => 'Leonard', 'pos' => 'SF', 'gp' => 68, 'pts' => 23.7, 'reb' => 6.1, 'ast' => 3.6, 'stl' => 1.6, 'blk' => 0.8, 'fg' => 0.526, 'fg3' => 0.392, 'ft' => 0.877, 'min' => 32.1],
            ['team' => 'LAC', 'first' => 'Paul', 'last' => 'George', 'pos' => 'SF', 'gp' => 74, 'pts' => 22.6, 'reb' => 5.2, 'ast' => 3.5, 'stl' => 1.5, 'blk' => 0.4, 'fg' => 0.459, 'fg3' => 0.413, 'ft' => 0.875, 'min' => 33.5],
            ['team' => 'LAC', 'first' => 'James', 'last' => 'Harden', 'pos' => 'PG', 'gp' => 72, 'pts' => 16.6, 'reb' => 5.3, 'ast' => 8.5, 'stl' => 1.1, 'blk' => 0.6, 'fg' => 0.424, 'fg3' => 0.382, 'ft' => 0.847, 'min' => 34.0],
            ['team' => 'LAC', 'first' => 'Ivica', 'last' => 'Zubac', 'pos' => 'C', 'gp' => 72, 'pts' => 11.5, 'reb' => 9.8, 'ast' => 2.1, 'stl' => 0.6, 'blk' => 1.2, 'fg' => 0.621, 'fg3' => 0.000, 'ft' => 0.731, 'min' => 26.5],
            ['team' => 'LAC', 'first' => 'Russell', 'last' => 'Westbrook', 'pos' => 'PG', 'gp' => 68, 'pts' => 11.2, 'reb' => 5.1, 'ast' => 4.5, 'stl' => 1.1, 'blk' => 0.3, 'fg' => 0.441, 'fg3' => 0.271, 'ft' => 0.681, 'min' => 24.5],
            ['team' => 'LAC', 'first' => 'Norman', 'last' => 'Powell', 'pos' => 'SG', 'gp' => 75, 'pts' => 14.5, 'reb' => 2.8, 'ast' => 1.8, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.491, 'fg3' => 0.421, 'ft' => 0.851, 'min' => 26.5],
            ['team' => 'LAC', 'first' => 'Terance', 'last' => 'Mann', 'pos' => 'SF', 'gp' => 65, 'pts' => 8.5, 'reb' => 3.5, 'ast' => 2.1, 'stl' => 0.7, 'blk' => 0.3, 'fg' => 0.471, 'fg3' => 0.381, 'ft' => 0.761, 'min' => 21.5],

            // LOS ANGELES LAKERS
            ['team' => 'LAL', 'first' => 'LeBron', 'last' => 'James', 'pos' => 'SF', 'gp' => 71, 'pts' => 25.7, 'reb' => 7.3, 'ast' => 8.3, 'stl' => 1.3, 'blk' => 0.5, 'fg' => 0.540, 'fg3' => 0.410, 'ft' => 0.757, 'min' => 35.3],
            ['team' => 'LAL', 'first' => 'Anthony', 'last' => 'Davis', 'pos' => 'C', 'gp' => 76, 'pts' => 24.7, 'reb' => 12.6, 'ast' => 3.5, 'stl' => 1.2, 'blk' => 2.3, 'fg' => 0.558, 'fg3' => 0.227, 'ft' => 0.805, 'min' => 35.5],
            ['team' => 'LAL', 'first' => 'Austin', 'last' => 'Reaves', 'pos' => 'SG', 'gp' => 79, 'pts' => 15.9, 'reb' => 4.5, 'ast' => 5.5, 'stl' => 1.0, 'blk' => 0.3, 'fg' => 0.489, 'fg3' => 0.408, 'ft' => 0.851, 'min' => 32.5],
            ['team' => 'LAL', 'first' => 'D\'Angelo', 'last' => 'Russell', 'pos' => 'PG', 'gp' => 65, 'pts' => 14.2, 'reb' => 2.8, 'ast' => 5.8, 'stl' => 0.8, 'blk' => 0.2, 'fg' => 0.431, 'fg3' => 0.371, 'ft' => 0.821, 'min' => 28.5],
            ['team' => 'LAL', 'first' => 'Rui', 'last' => 'Hachimura', 'pos' => 'PF', 'gp' => 68, 'pts' => 13.5, 'reb' => 4.2, 'ast' => 1.5, 'stl' => 0.6, 'blk' => 0.4, 'fg' => 0.521, 'fg3' => 0.391, 'ft' => 0.771, 'min' => 26.5],
            ['team' => 'LAL', 'first' => 'Taurean', 'last' => 'Prince', 'pos' => 'SF', 'gp' => 70, 'pts' => 9.5, 'reb' => 3.2, 'ast' => 1.5, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.461, 'fg3' => 0.401, 'ft' => 0.751, 'min' => 22.5],
            ['team' => 'LAL', 'first' => 'Gabe', 'last' => 'Vincent', 'pos' => 'SG', 'gp' => 45, 'pts' => 7.5, 'reb' => 2.1, 'ast' => 2.8, 'stl' => 0.9, 'blk' => 0.2, 'fg' => 0.391, 'fg3' => 0.331, 'ft' => 0.821, 'min' => 19.5],

            // MEMPHIS GRIZZLIES
            ['team' => 'MEM', 'first' => 'Ja', 'last' => 'Morant', 'pos' => 'PG', 'gp' => 9, 'pts' => 25.1, 'reb' => 5.6, 'ast' => 8.1, 'stl' => 1.1, 'blk' => 0.5, 'fg' => 0.479, 'fg3' => 0.308, 'ft' => 0.763, 'min' => 32.0],
            ['team' => 'MEM', 'first' => 'Jaren', 'last' => 'Jackson Jr.', 'pos' => 'C', 'gp' => 50, 'pts' => 22.6, 'reb' => 5.9, 'ast' => 2.2, 'stl' => 0.9, 'blk' => 3.0, 'fg' => 0.467, 'fg3' => 0.362, 'ft' => 0.840, 'min' => 30.5],
            ['team' => 'MEM', 'first' => 'Desmond', 'last' => 'Bane', 'pos' => 'SG', 'gp' => 55, 'pts' => 20.1, 'reb' => 4.4, 'ast' => 4.5, 'stl' => 1.1, 'blk' => 0.3, 'fg' => 0.449, 'fg3' => 0.388, 'ft' => 0.835, 'min' => 33.5],
            ['team' => 'MEM', 'first' => 'Marcus', 'last' => 'Smart', 'pos' => 'PG', 'gp' => 55, 'pts' => 11.5, 'reb' => 3.5, 'ast' => 5.8, 'stl' => 1.5, 'blk' => 0.4, 'fg' => 0.401, 'fg3' => 0.321, 'ft' => 0.771, 'min' => 27.5],
            ['team' => 'MEM', 'first' => 'Ziaire', 'last' => 'Williams', 'pos' => 'SF', 'gp' => 60, 'pts' => 10.2, 'reb' => 3.5, 'ast' => 2.1, 'stl' => 0.8, 'blk' => 0.5, 'fg' => 0.441, 'fg3' => 0.361, 'ft' => 0.751, 'min' => 24.5],
            ['team' => 'MEM', 'first' => 'Santi', 'last' => 'Aldama', 'pos' => 'PF', 'gp' => 68, 'pts' => 11.8, 'reb' => 5.5, 'ast' => 2.2, 'stl' => 0.7, 'blk' => 0.8, 'fg' => 0.471, 'fg3' => 0.371, 'ft' => 0.731, 'min' => 25.5],
            ['team' => 'MEM', 'first' => 'Luke', 'last' => 'Kennard', 'pos' => 'SG', 'gp' => 65, 'pts' => 9.5, 'reb' => 2.8, 'ast' => 2.1, 'stl' => 0.6, 'blk' => 0.2, 'fg' => 0.461, 'fg3' => 0.431, 'ft' => 0.891, 'min' => 21.5],

            // MIAMI HEAT
            ['team' => 'MIA', 'first' => 'Bam', 'last' => 'Adebayo', 'pos' => 'C', 'gp' => 71, 'pts' => 19.3, 'reb' => 10.4, 'ast' => 3.9, 'stl' => 1.1, 'blk' => 0.8, 'fg' => 0.530, 'fg3' => 0.167, 'ft' => 0.742, 'min' => 34.2],
            ['team' => 'MIA', 'first' => 'Tyler', 'last' => 'Herro', 'pos' => 'SG', 'gp' => 66, 'pts' => 20.8, 'reb' => 5.3, 'ast' => 4.5, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.441, 'fg3' => 0.387, 'ft' => 0.864, 'min' => 33.5],
            ['team' => 'MIA', 'first' => 'Jimmy', 'last' => 'Butler', 'pos' => 'SF', 'gp' => 60, 'pts' => 20.8, 'reb' => 5.3, 'ast' => 5.0, 'stl' => 1.3, 'blk' => 0.3, 'fg' => 0.507, 'fg3' => 0.242, 'ft' => 0.830, 'min' => 33.8],
            ['team' => 'MIA', 'first' => 'Terry', 'last' => 'Rozier', 'pos' => 'SG', 'gp' => 36, 'pts' => 17.2, 'reb' => 3.8, 'ast' => 4.1, 'stl' => 1.1, 'blk' => 0.3, 'fg' => 0.441, 'fg3' => 0.371, 'ft' => 0.831, 'min' => 30.5],
            ['team' => 'MIA', 'first' => 'Duncan', 'last' => 'Robinson', 'pos' => 'SG', 'gp' => 73, 'pts' => 12.5, 'reb' => 3.1, 'ast' => 2.5, 'stl' => 0.7, 'blk' => 0.2, 'fg' => 0.441, 'fg3' => 0.411, 'ft' => 0.881, 'min' => 27.5],
            ['team' => 'MIA', 'first' => 'Caleb', 'last' => 'Martin', 'pos' => 'SF', 'gp' => 68, 'pts' => 9.5, 'reb' => 4.5, 'ast' => 2.1, 'stl' => 1.0, 'blk' => 0.5, 'fg' => 0.491, 'fg3' => 0.371, 'ft' => 0.741, 'min' => 24.5],
            ['team' => 'MIA', 'first' => 'Haywood', 'last' => 'Highsmith', 'pos' => 'SF', 'gp' => 72, 'pts' => 8.2, 'reb' => 3.8, 'ast' => 1.2, 'stl' => 0.8, 'blk' => 0.4, 'fg' => 0.471, 'fg3' => 0.391, 'ft' => 0.721, 'min' => 21.5],

            // MILWAUKEE BUCKS
            ['team' => 'MIL', 'first' => 'Giannis', 'last' => 'Antetokounmpo', 'pos' => 'PF', 'gp' => 73, 'pts' => 30.4, 'reb' => 11.5, 'ast' => 6.5, 'stl' => 1.2, 'blk' => 1.1, 'fg' => 0.611, 'fg3' => 0.274, 'ft' => 0.657, 'min' => 35.2],
            ['team' => 'MIL', 'first' => 'Damian', 'last' => 'Lillard', 'pos' => 'PG', 'gp' => 73, 'pts' => 24.3, 'reb' => 4.4, 'ast' => 7.0, 'stl' => 0.9, 'blk' => 0.4, 'fg' => 0.424, 'fg3' => 0.351, 'ft' => 0.916, 'min' => 35.5],
            ['team' => 'MIL', 'first' => 'Brook', 'last' => 'Lopez', 'pos' => 'C', 'gp' => 73, 'pts' => 12.7, 'reb' => 4.8, 'ast' => 1.8, 'stl' => 0.7, 'blk' => 2.3, 'fg' => 0.518, 'fg3' => 0.344, 'ft' => 0.810, 'min' => 27.5],
            ['team' => 'MIL', 'first' => 'Khris', 'last' => 'Middleton', 'pos' => 'SF', 'gp' => 42, 'pts' => 14.2, 'reb' => 4.5, 'ast' => 4.1, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.471, 'fg3' => 0.381, 'ft' => 0.871, 'min' => 28.5],
            ['team' => 'MIL', 'first' => 'Bobby', 'last' => 'Portis', 'pos' => 'PF', 'gp' => 72, 'pts' => 14.5, 'reb' => 8.2, 'ast' => 1.5, 'stl' => 0.7, 'blk' => 0.4, 'fg' => 0.481, 'fg3' => 0.361, 'ft' => 0.751, 'min' => 26.5],
            ['team' => 'MIL', 'first' => 'Patrick', 'last' => 'Beverley', 'pos' => 'PG', 'gp' => 55, 'pts' => 7.2, 'reb' => 3.5, 'ast' => 2.8, 'stl' => 1.2, 'blk' => 0.2, 'fg' => 0.401, 'fg3' => 0.361, 'ft' => 0.781, 'min' => 20.5],
            ['team' => 'MIL', 'first' => 'MarJon', 'last' => 'Beauchamp', 'pos' => 'SF', 'gp' => 60, 'pts' => 7.5, 'reb' => 3.8, 'ast' => 1.2, 'stl' => 0.8, 'blk' => 0.5, 'fg' => 0.441, 'fg3' => 0.351, 'ft' => 0.721, 'min' => 19.5],

            // MINNESOTA TIMBERWOLVES
            ['team' => 'MIN', 'first' => 'Anthony', 'last' => 'Edwards', 'pos' => 'SG', 'gp' => 79, 'pts' => 25.9, 'reb' => 5.4, 'ast' => 5.1, 'stl' => 1.3, 'blk' => 0.5, 'fg' => 0.464, 'fg3' => 0.359, 'ft' => 0.831, 'min' => 35.5],
            ['team' => 'MIN', 'first' => 'Karl-Anthony', 'last' => 'Towns', 'pos' => 'C', 'gp' => 61, 'pts' => 21.4, 'reb' => 8.3, 'ast' => 3.0, 'stl' => 0.9, 'blk' => 0.6, 'fg' => 0.500, 'fg3' => 0.410, 'ft' => 0.867, 'min' => 32.5],
            ['team' => 'MIN', 'first' => 'Rudy', 'last' => 'Gobert', 'pos' => 'C', 'gp' => 76, 'pts' => 14.0, 'reb' => 12.9, 'ast' => 1.8, 'stl' => 0.8, 'blk' => 2.1, 'fg' => 0.622, 'fg3' => 0.000, 'ft' => 0.640, 'min' => 30.5],
            ['team' => 'MIN', 'first' => 'Mike', 'last' => 'Conley', 'pos' => 'PG', 'gp' => 67, 'pts' => 10.5, 'reb' => 2.8, 'ast' => 5.5, 'stl' => 1.0, 'blk' => 0.2, 'fg' => 0.471, 'fg3' => 0.421, 'ft' => 0.881, 'min' => 27.5],
            ['team' => 'MIN', 'first' => 'Jaden', 'last' => 'McDaniels', 'pos' => 'SF', 'gp' => 72, 'pts' => 13.5, 'reb' => 4.5, 'ast' => 1.8, 'stl' => 1.2, 'blk' => 0.8, 'fg' => 0.481, 'fg3' => 0.371, 'ft' => 0.751, 'min' => 28.5],
            ['team' => 'MIN', 'first' => 'Naz', 'last' => 'Reid', 'pos' => 'C', 'gp' => 74, 'pts' => 11.8, 'reb' => 5.2, 'ast' => 1.5, 'stl' => 0.6, 'blk' => 1.2, 'fg' => 0.511, 'fg3' => 0.381, 'ft' => 0.781, 'min' => 22.5],
            ['team' => 'MIN', 'first' => 'Kyle', 'last' => 'Anderson', 'pos' => 'SF', 'gp' => 65, 'pts' => 7.5, 'reb' => 4.8, 'ast' => 3.2, 'stl' => 0.9, 'blk' => 0.5, 'fg' => 0.521, 'fg3' => 0.341, 'ft' => 0.711, 'min' => 20.5],

            // NEW ORLEANS PELICANS
            ['team' => 'NOP', 'first' => 'Zion', 'last' => 'Williamson', 'pos' => 'PF', 'gp' => 40, 'pts' => 22.9, 'reb' => 5.8, 'ast' => 5.0, 'stl' => 1.1, 'blk' => 0.6, 'fg' => 0.548, 'fg3' => 0.333, 'ft' => 0.667, 'min' => 30.5],
            ['team' => 'NOP', 'first' => 'Brandon', 'last' => 'Ingram', 'pos' => 'SF', 'gp' => 47, 'pts' => 24.3, 'reb' => 5.5, 'ast' => 5.7, 'stl' => 0.8, 'blk' => 0.5, 'fg' => 0.476, 'fg3' => 0.352, 'ft' => 0.850, 'min' => 34.5],
            ['team' => 'NOP', 'first' => 'CJ', 'last' => 'McCollum', 'pos' => 'SG', 'gp' => 52, 'pts' => 19.8, 'reb' => 4.2, 'ast' => 4.9, 'stl' => 0.8, 'blk' => 0.4, 'fg' => 0.449, 'fg3' => 0.381, 'ft' => 0.843, 'min' => 33.0],
            ['team' => 'NOP', 'first' => 'Jonas', 'last' => 'Valanciunas', 'pos' => 'C', 'gp' => 65, 'pts' => 12.5, 'reb' => 10.2, 'ast' => 2.1, 'stl' => 0.5, 'blk' => 0.8, 'fg' => 0.551, 'fg3' => 0.321, 'ft' => 0.761, 'min' => 26.5],
            ['team' => 'NOP', 'first' => 'Herbert', 'last' => 'Jones', 'pos' => 'SF', 'gp' => 62, 'pts' => 9.5, 'reb' => 4.2, 'ast' => 3.1, 'stl' => 1.3, 'blk' => 0.6, 'fg' => 0.481, 'fg3' => 0.351, 'ft' => 0.731, 'min' => 27.5],
            ['team' => 'NOP', 'first' => 'Trey', 'last' => 'Murphy III', 'pos' => 'SF', 'gp' => 55, 'pts' => 14.2, 'reb' => 4.1, 'ast' => 1.8, 'stl' => 0.8, 'blk' => 0.4, 'fg' => 0.471, 'fg3' => 0.401, 'ft' => 0.811, 'min' => 26.5],
            ['team' => 'NOP', 'first' => 'Jose', 'last' => 'Alvarado', 'pos' => 'PG', 'gp' => 68, 'pts' => 10.5, 'reb' => 2.5, 'ast' => 3.8, 'stl' => 1.8, 'blk' => 0.3, 'fg' => 0.441, 'fg3' => 0.371, 'ft' => 0.791, 'min' => 22.5],

            // NEW YORK KNICKS
            ['team' => 'NYK', 'first' => 'Jalen', 'last' => 'Brunson', 'pos' => 'PG', 'gp' => 77, 'pts' => 28.7, 'reb' => 3.6, 'ast' => 6.7, 'stl' => 0.9, 'blk' => 0.2, 'fg' => 0.479, 'fg3' => 0.401, 'ft' => 0.846, 'min' => 35.6],
            ['team' => 'NYK', 'first' => 'Julius', 'last' => 'Randle', 'pos' => 'PF', 'gp' => 55, 'pts' => 24.0, 'reb' => 9.2, 'ast' => 5.0, 'stl' => 0.8, 'blk' => 0.4, 'fg' => 0.459, 'fg3' => 0.316, 'ft' => 0.788, 'min' => 35.0],
            ['team' => 'NYK', 'first' => 'OG', 'last' => 'Anunoby', 'pos' => 'SF', 'gp' => 67, 'pts' => 14.7, 'reb' => 4.4, 'ast' => 1.9, 'stl' => 1.7, 'blk' => 0.7, 'fg' => 0.491, 'fg3' => 0.378, 'ft' => 0.772, 'min' => 31.5],
            ['team' => 'NYK', 'first' => 'Donte', 'last' => 'DiVincenzo', 'pos' => 'SG', 'gp' => 75, 'pts' => 15.5, 'reb' => 4.5, 'ast' => 3.5, 'stl' => 1.1, 'blk' => 0.3, 'fg' => 0.451, 'fg3' => 0.421, 'ft' => 0.831, 'min' => 30.5],
            ['team' => 'NYK', 'first' => 'Isaiah', 'last' => 'Hartenstein', 'pos' => 'C', 'gp' => 72, 'pts' => 9.2, 'reb' => 8.8, 'ast' => 3.1, 'stl' => 0.9, 'blk' => 1.1, 'fg' => 0.601, 'fg3' => 0.000, 'ft' => 0.721, 'min' => 24.5],
            ['team' => 'NYK', 'first' => 'Josh', 'last' => 'Hart', 'pos' => 'SF', 'gp' => 78, 'pts' => 9.5, 'reb' => 8.2, 'ast' => 4.2, 'stl' => 1.1, 'blk' => 0.3, 'fg' => 0.481, 'fg3' => 0.341, 'ft' => 0.681, 'min' => 30.5],
            ['team' => 'NYK', 'first' => 'Precious', 'last' => 'Achiuwa', 'pos' => 'PF', 'gp' => 60, 'pts' => 7.5, 'reb' => 5.8, 'ast' => 1.2, 'stl' => 0.7, 'blk' => 0.8, 'fg' => 0.521, 'fg3' => 0.271, 'ft' => 0.651, 'min' => 19.5],

            // OKLAHOMA CITY THUNDER
            ['team' => 'OKC', 'first' => 'Shai', 'last' => 'Gilgeous-Alexander', 'pos' => 'PG', 'gp' => 75, 'pts' => 30.1, 'reb' => 5.5, 'ast' => 6.2, 'stl' => 2.0, 'blk' => 0.9, 'fg' => 0.535, 'fg3' => 0.353, 'ft' => 0.874, 'min' => 34.0],
            ['team' => 'OKC', 'first' => 'Jalen', 'last' => 'Williams', 'pos' => 'SF', 'gp' => 74, 'pts' => 23.0, 'reb' => 4.5, 'ast' => 5.6, 'stl' => 1.3, 'blk' => 0.6, 'fg' => 0.513, 'fg3' => 0.360, 'ft' => 0.826, 'min' => 33.5],
            ['team' => 'OKC', 'first' => 'Chet', 'last' => 'Holmgren', 'pos' => 'C', 'gp' => 69, 'pts' => 16.5, 'reb' => 7.9, 'ast' => 2.4, 'stl' => 0.9, 'blk' => 2.3, 'fg' => 0.531, 'fg3' => 0.384, 'ft' => 0.815, 'min' => 29.5],
            ['team' => 'OKC', 'first' => 'Lu', 'last' => 'Dort', 'pos' => 'SG', 'gp' => 72, 'pts' => 13.5, 'reb' => 3.8, 'ast' => 2.1, 'stl' => 1.3, 'blk' => 0.5, 'fg' => 0.441, 'fg3' => 0.371, 'ft' => 0.801, 'min' => 28.5],
            ['team' => 'OKC', 'first' => 'Josh', 'last' => 'Giddey', 'pos' => 'PG', 'gp' => 55, 'pts' => 12.5, 'reb' => 6.5, 'ast' => 6.2, 'stl' => 0.8, 'blk' => 0.4, 'fg' => 0.431, 'fg3' => 0.301, 'ft' => 0.671, 'min' => 28.5],
            ['team' => 'OKC', 'first' => 'Isaiah', 'last' => 'Joe', 'pos' => 'SG', 'gp' => 68, 'pts' => 8.5, 'reb' => 2.5, 'ast' => 1.8, 'stl' => 0.7, 'blk' => 0.3, 'fg' => 0.441, 'fg3' => 0.411, 'ft' => 0.841, 'min' => 20.5],
            ['team' => 'OKC', 'first' => 'Kenrich', 'last' => 'Williams', 'pos' => 'SF', 'gp' => 65, 'pts' => 6.5, 'reb' => 4.2, 'ast' => 2.1, 'stl' => 1.0, 'blk' => 0.4, 'fg' => 0.471, 'fg3' => 0.351, 'ft' => 0.731, 'min' => 19.5],

            // ORLANDO MAGIC
            ['team' => 'ORL', 'first' => 'Paolo', 'last' => 'Banchero', 'pos' => 'PF', 'gp' => 80, 'pts' => 22.6, 'reb' => 6.9, 'ast' => 5.4, 'stl' => 1.0, 'blk' => 0.8, 'fg' => 0.457, 'fg3' => 0.328, 'ft' => 0.731, 'min' => 34.5],
            ['team' => 'ORL', 'first' => 'Franz', 'last' => 'Wagner', 'pos' => 'SF', 'gp' => 77, 'pts' => 19.7, 'reb' => 4.8, 'ast' => 3.6, 'stl' => 0.9, 'blk' => 0.4, 'fg' => 0.485, 'fg3' => 0.338, 'ft' => 0.793, 'min' => 32.0],
            ['team' => 'ORL', 'first' => 'Wendell', 'last' => 'Carter Jr.', 'pos' => 'C', 'gp' => 55, 'pts' => 12.5, 'reb' => 8.5, 'ast' => 2.5, 'stl' => 0.7, 'blk' => 1.0, 'fg' => 0.530, 'fg3' => 0.200, 'ft' => 0.740, 'min' => 27.5],
            ['team' => 'ORL', 'first' => 'Markelle', 'last' => 'Fultz', 'pos' => 'PG', 'gp' => 50, 'pts' => 12.2, 'reb' => 3.5, 'ast' => 5.8, 'stl' => 1.1, 'blk' => 0.4, 'fg' => 0.491, 'fg3' => 0.281, 'ft' => 0.721, 'min' => 27.5],
            ['team' => 'ORL', 'first' => 'Jalen', 'last' => 'Suggs', 'pos' => 'PG', 'gp' => 72, 'pts' => 12.8, 'reb' => 3.8, 'ast' => 4.5, 'stl' => 1.4, 'blk' => 0.5, 'fg' => 0.441, 'fg3' => 0.341, 'ft' => 0.751, 'min' => 28.5],
            ['team' => 'ORL', 'first' => 'Jonathan', 'last' => 'Isaac', 'pos' => 'PF', 'gp' => 55, 'pts' => 9.5, 'reb' => 5.5, 'ast' => 1.5, 'stl' => 1.0, 'blk' => 1.8, 'fg' => 0.461, 'fg3' => 0.321, 'ft' => 0.701, 'min' => 24.5],
            ['team' => 'ORL', 'first' => 'Gary', 'last' => 'Harris', 'pos' => 'SG', 'gp' => 60, 'pts' => 8.2, 'reb' => 2.5, 'ast' => 1.8, 'stl' => 0.9, 'blk' => 0.2, 'fg' => 0.461, 'fg3' => 0.401, 'ft' => 0.841, 'min' => 21.5],

            // PHILADELPHIA 76ERS
            ['team' => 'PHI', 'first' => 'Joel', 'last' => 'Embiid', 'pos' => 'C', 'gp' => 39, 'pts' => 34.7, 'reb' => 11.0, 'ast' => 5.6, 'stl' => 1.2, 'blk' => 1.7, 'fg' => 0.528, 'fg3' => 0.378, 'ft' => 0.857, 'min' => 33.5],
            ['team' => 'PHI', 'first' => 'Tyrese', 'last' => 'Maxey', 'pos' => 'PG', 'gp' => 70, 'pts' => 25.9, 'reb' => 3.7, 'ast' => 6.2, 'stl' => 1.0, 'blk' => 0.4, 'fg' => 0.480, 'fg3' => 0.362, 'ft' => 0.877, 'min' => 35.8],
            ['team' => 'PHI', 'first' => 'Tobias', 'last' => 'Harris', 'pos' => 'SF', 'gp' => 72, 'pts' => 17.2, 'reb' => 6.5, 'ast' => 3.2, 'stl' => 0.7, 'blk' => 0.5, 'fg' => 0.501, 'fg3' => 0.381, 'ft' => 0.821, 'min' => 31.5],
            ['team' => 'PHI', 'first' => 'Kelly', 'last' => 'Oubre Jr.', 'pos' => 'SF', 'gp' => 62, 'pts' => 15.4, 'reb' => 5.0, 'ast' => 1.8, 'stl' => 1.0, 'blk' => 0.4, 'fg' => 0.451, 'fg3' => 0.321, 'ft' => 0.721, 'min' => 28.5],
            ['team' => 'PHI', 'first' => 'Nicolas', 'last' => 'Batum', 'pos' => 'SF', 'gp' => 65, 'pts' => 7.5, 'reb' => 4.2, 'ast' => 2.1, 'stl' => 0.8, 'blk' => 0.6, 'fg' => 0.451, 'fg3' => 0.391, 'ft' => 0.771, 'min' => 22.5],
            ['team' => 'PHI', 'first' => 'Patrick', 'last' => 'Beverley', 'pos' => 'PG', 'gp' => 50, 'pts' => 6.8, 'reb' => 3.2, 'ast' => 2.5, 'stl' => 1.1, 'blk' => 0.2, 'fg' => 0.391, 'fg3' => 0.341, 'ft' => 0.771, 'min' => 18.5],
            ['team' => 'PHI', 'first' => 'Mo', 'last' => 'Bamba', 'pos' => 'C', 'gp' => 45, 'pts' => 7.2, 'reb' => 5.8, 'ast' => 0.8, 'stl' => 0.5, 'blk' => 1.5, 'fg' => 0.481, 'fg3' => 0.351, 'ft' => 0.691, 'min' => 18.5],

            // PHOENIX SUNS
            ['team' => 'PHX', 'first' => 'Kevin', 'last' => 'Durant', 'pos' => 'SF', 'gp' => 75, 'pts' => 27.1, 'reb' => 6.6, 'ast' => 4.0, 'stl' => 0.8, 'blk' => 1.2, 'fg' => 0.527, 'fg3' => 0.413, 'ft' => 0.856, 'min' => 36.0],
            ['team' => 'PHX', 'first' => 'Devin', 'last' => 'Booker', 'pos' => 'SG', 'gp' => 68, 'pts' => 27.1, 'reb' => 4.5, 'ast' => 6.9, 'stl' => 1.0, 'blk' => 0.4, 'fg' => 0.490, 'fg3' => 0.363, 'ft' => 0.876, 'min' => 36.5],
            ['team' => 'PHX', 'first' => 'Bradley', 'last' => 'Beal', 'pos' => 'SG', 'gp' => 53, 'pts' => 18.2, 'reb' => 4.0, 'ast' => 5.0, 'stl' => 1.0, 'blk' => 0.3, 'fg' => 0.490, 'fg3' => 0.380, 'ft' => 0.789, 'min' => 30.5],
            ['team' => 'PHX', 'first' => 'Jusuf', 'last' => 'Nurkic', 'pos' => 'C', 'gp' => 68, 'pts' => 11.5, 'reb' => 10.2, 'ast' => 3.5, 'stl' => 0.7, 'blk' => 0.9, 'fg' => 0.531, 'fg3' => 0.000, 'ft' => 0.651, 'min' => 26.5],
            ['team' => 'PHX', 'first' => 'Grayson', 'last' => 'Allen', 'pos' => 'SG', 'gp' => 70, 'pts' => 12.5, 'reb' => 3.5, 'ast' => 2.5, 'stl' => 0.9, 'blk' => 0.3, 'fg' => 0.461, 'fg3' => 0.421, 'ft' => 0.871, 'min' => 26.5],
            ['team' => 'PHX', 'first' => 'Eric', 'last' => 'Gordon', 'pos' => 'SG', 'gp' => 60, 'pts' => 11.5, 'reb' => 2.5, 'ast' => 2.1, 'stl' => 0.8, 'blk' => 0.2, 'fg' => 0.441, 'fg3' => 0.401, 'ft' => 0.841, 'min' => 22.5],
            ['team' => 'PHX', 'first' => 'Drew', 'last' => 'Eubanks', 'pos' => 'C', 'gp' => 55, 'pts' => 8.5, 'reb' => 6.5, 'ast' => 1.2, 'stl' => 0.5, 'blk' => 0.8, 'fg' => 0.581, 'fg3' => 0.000, 'ft' => 0.661, 'min' => 19.5],

            // PORTLAND TRAIL BLAZERS
            ['team' => 'POR', 'first' => 'Anfernee', 'last' => 'Simons', 'pos' => 'PG', 'gp' => 55, 'pts' => 21.1, 'reb' => 3.4, 'ast' => 5.6, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.444, 'fg3' => 0.381, 'ft' => 0.873, 'min' => 33.0],
            ['team' => 'POR', 'first' => 'Jerami', 'last' => 'Grant', 'pos' => 'PF', 'gp' => 62, 'pts' => 20.4, 'reb' => 3.8, 'ast' => 2.7, 'stl' => 1.1, 'blk' => 0.6, 'fg' => 0.451, 'fg3' => 0.385, 'ft' => 0.859, 'min' => 32.5],
            ['team' => 'POR', 'first' => 'Deandre', 'last' => 'Ayton', 'pos' => 'C', 'gp' => 40, 'pts' => 14.2, 'reb' => 9.4, 'ast' => 1.5, 'stl' => 0.6, 'blk' => 0.8, 'fg' => 0.574, 'fg3' => 0.000, 'ft' => 0.750, 'min' => 27.5],
            ['team' => 'POR', 'first' => 'Scoot', 'last' => 'Henderson', 'pos' => 'PG', 'gp' => 65, 'pts' => 14.5, 'reb' => 3.8, 'ast' => 5.2, 'stl' => 0.9, 'blk' => 0.3, 'fg' => 0.421, 'fg3' => 0.301, 'ft' => 0.731, 'min' => 28.5],
            ['team' => 'POR', 'first' => 'Shaedon', 'last' => 'Sharpe', 'pos' => 'SG', 'gp' => 55, 'pts' => 15.2, 'reb' => 3.5, 'ast' => 2.2, 'stl' => 1.0, 'blk' => 0.4, 'fg' => 0.451, 'fg3' => 0.351, 'ft' => 0.761, 'min' => 27.5],
            ['team' => 'POR', 'first' => 'Matisse', 'last' => 'Thybulle', 'pos' => 'SF', 'gp' => 60, 'pts' => 7.5, 'reb' => 2.8, 'ast' => 1.5, 'stl' => 1.5, 'blk' => 0.8, 'fg' => 0.451, 'fg3' => 0.361, 'ft' => 0.721, 'min' => 21.5],
            ['team' => 'POR', 'first' => 'Robert', 'last' => 'Williams III', 'pos' => 'C', 'gp' => 35, 'pts' => 8.5, 'reb' => 7.5, 'ast' => 1.2, 'stl' => 0.8, 'blk' => 1.8, 'fg' => 0.601, 'fg3' => 0.000, 'ft' => 0.601, 'min' => 20.5],

            // SACRAMENTO KINGS
            ['team' => 'SAC', 'first' => 'De\'Aaron', 'last' => 'Fox', 'pos' => 'PG', 'gp' => 78, 'pts' => 24.1, 'reb' => 4.3, 'ast' => 5.9, 'stl' => 1.5, 'blk' => 0.4, 'fg' => 0.476, 'fg3' => 0.320, 'ft' => 0.769, 'min' => 34.5],
            ['team' => 'SAC', 'first' => 'Domantas', 'last' => 'Sabonis', 'pos' => 'C', 'gp' => 79, 'pts' => 19.9, 'reb' => 13.8, 'ast' => 8.0, 'stl' => 0.8, 'blk' => 0.4, 'fg' => 0.581, 'fg3' => 0.286, 'ft' => 0.676, 'min' => 34.5],
            ['team' => 'SAC', 'first' => 'Kevin', 'last' => 'Huerter', 'pos' => 'SG', 'gp' => 55, 'pts' => 12.5, 'reb' => 3.5, 'ast' => 3.0, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.445, 'fg3' => 0.380, 'ft' => 0.820, 'min' => 27.0],
            ['team' => 'SAC', 'first' => 'Harrison', 'last' => 'Barnes', 'pos' => 'SF', 'gp' => 72, 'pts' => 14.5, 'reb' => 5.2, 'ast' => 2.1, 'stl' => 0.8, 'blk' => 0.5, 'fg' => 0.491, 'fg3' => 0.381, 'ft' => 0.791, 'min' => 29.5],
            ['team' => 'SAC', 'first' => 'Malik', 'last' => 'Monk', 'pos' => 'SG', 'gp' => 70, 'pts' => 13.5, 'reb' => 3.2, 'ast' => 4.5, 'stl' => 0.9, 'blk' => 0.2, 'fg' => 0.461, 'fg3' => 0.401, 'ft' => 0.841, 'min' => 27.5],
            ['team' => 'SAC', 'first' => 'Trey', 'last' => 'Lyles', 'pos' => 'PF', 'gp' => 65, 'pts' => 9.5, 'reb' => 5.5, 'ast' => 1.5, 'stl' => 0.5, 'blk' => 0.5, 'fg' => 0.481, 'fg3' => 0.371, 'ft' => 0.761, 'min' => 22.5],
            ['team' => 'SAC', 'first' => 'Alex', 'last' => 'Len', 'pos' => 'C', 'gp' => 50, 'pts' => 7.5, 'reb' => 6.5, 'ast' => 1.2, 'stl' => 0.5, 'blk' => 0.8, 'fg' => 0.561, 'fg3' => 0.000, 'ft' => 0.651, 'min' => 18.5],

            // SAN ANTONIO SPURS
            ['team' => 'SAS', 'first' => 'Victor', 'last' => 'Wembanyama', 'pos' => 'C', 'gp' => 71, 'pts' => 21.4, 'reb' => 10.6, 'ast' => 3.9, 'stl' => 1.2, 'blk' => 3.6, 'fg' => 0.463, 'fg3' => 0.323, 'ft' => 0.792, 'min' => 29.7],
            ['team' => 'SAS', 'first' => 'Devin', 'last' => 'Vassell', 'pos' => 'SG', 'gp' => 42, 'pts' => 19.5, 'reb' => 3.8, 'ast' => 3.5, 'stl' => 1.1, 'blk' => 0.4, 'fg' => 0.452, 'fg3' => 0.378, 'ft' => 0.840, 'min' => 32.0],
            ['team' => 'SAS', 'first' => 'Chris', 'last' => 'Paul', 'pos' => 'PG', 'gp' => 58, 'pts' => 9.4, 'reb' => 4.0, 'ast' => 6.8, 'stl' => 1.3, 'blk' => 0.2, 'fg' => 0.442, 'fg3' => 0.371, 'ft' => 0.836, 'min' => 27.5],
            ['team' => 'SAS', 'first' => 'Keldon', 'last' => 'Johnson', 'pos' => 'SF', 'gp' => 68, 'pts' => 14.5, 'reb' => 5.2, 'ast' => 2.5, 'stl' => 0.9, 'blk' => 0.4, 'fg' => 0.451, 'fg3' => 0.341, 'ft' => 0.761, 'min' => 28.5],
            ['team' => 'SAS', 'first' => 'Jeremy', 'last' => 'Sochan', 'pos' => 'PF', 'gp' => 65, 'pts' => 12.5, 'reb' => 5.8, 'ast' => 3.2, 'stl' => 0.9, 'blk' => 0.5, 'fg' => 0.461, 'fg3' => 0.321, 'ft' => 0.681, 'min' => 27.5],
            ['team' => 'SAS', 'first' => 'Zach', 'last' => 'Collins', 'pos' => 'C', 'gp' => 60, 'pts' => 10.5, 'reb' => 6.2, 'ast' => 2.8, 'stl' => 0.6, 'blk' => 0.8, 'fg' => 0.491, 'fg3' => 0.351, 'ft' => 0.741, 'min' => 23.5],
            ['team' => 'SAS', 'first' => 'Tre', 'last' => 'Jones', 'pos' => 'PG', 'gp' => 70, 'pts' => 9.5, 'reb' => 2.8, 'ast' => 5.5, 'stl' => 1.2, 'blk' => 0.2, 'fg' => 0.471, 'fg3' => 0.361, 'ft' => 0.791, 'min' => 24.5],

            // TORONTO RAPTORS
            ['team' => 'TOR', 'first' => 'Scottie', 'last' => 'Barnes', 'pos' => 'SF', 'gp' => 60, 'pts' => 19.9, 'reb' => 8.2, 'ast' => 6.1, 'stl' => 1.3, 'blk' => 0.7, 'fg' => 0.479, 'fg3' => 0.328, 'ft' => 0.684, 'min' => 35.5],
            ['team' => 'TOR', 'first' => 'RJ', 'last' => 'Barrett', 'pos' => 'SG', 'gp' => 55, 'pts' => 21.8, 'reb' => 6.4, 'ast' => 3.6, 'stl' => 0.9, 'blk' => 0.4, 'fg' => 0.455, 'fg3' => 0.359, 'ft' => 0.771, 'min' => 35.0],
            ['team' => 'TOR', 'first' => 'Immanuel', 'last' => 'Quickley', 'pos' => 'PG', 'gp' => 57, 'pts' => 18.6, 'reb' => 4.8, 'ast' => 6.8, 'stl' => 1.1, 'blk' => 0.3, 'fg' => 0.439, 'fg3' => 0.371, 'ft' => 0.851, 'min' => 33.5],
            ['team' => 'TOR', 'first' => 'Pascal', 'last' => 'Siakam', 'pos' => 'PF', 'gp' => 24, 'pts' => 22.5, 'reb' => 7.5, 'ast' => 4.5, 'stl' => 1.0, 'blk' => 0.5, 'fg' => 0.521, 'fg3' => 0.331, 'ft' => 0.731, 'min' => 35.5],
            ['team' => 'TOR', 'first' => 'Jakob', 'last' => 'Poeltl', 'pos' => 'C', 'gp' => 72, 'pts' => 12.5, 'reb' => 9.8, 'ast' => 3.5, 'stl' => 0.7, 'blk' => 1.5, 'fg' => 0.611, 'fg3' => 0.000, 'ft' => 0.641, 'min' => 27.5],
            ['team' => 'TOR', 'first' => 'Bruce', 'last' => 'Brown', 'pos' => 'SF', 'gp' => 65, 'pts' => 10.5, 'reb' => 5.2, 'ast' => 3.5, 'stl' => 1.1, 'blk' => 0.4, 'fg' => 0.481, 'fg3' => 0.351, 'ft' => 0.721, 'min' => 26.5],
            ['team' => 'TOR', 'first' => 'Gary', 'last' => 'Trent Jr.', 'pos' => 'SG', 'gp' => 68, 'pts' => 13.5, 'reb' => 2.8, 'ast' => 1.8, 'stl' => 1.0, 'blk' => 0.2, 'fg' => 0.441, 'fg3' => 0.381, 'ft' => 0.871, 'min' => 27.5],

            // UTAH JAZZ
            ['team' => 'UTA', 'first' => 'Lauri', 'last' => 'Markkanen', 'pos' => 'PF', 'gp' => 55, 'pts' => 23.2, 'reb' => 8.2, 'ast' => 2.0, 'stl' => 0.6, 'blk' => 0.6, 'fg' => 0.491, 'fg3' => 0.384, 'ft' => 0.879, 'min' => 33.5],
            ['team' => 'UTA', 'first' => 'Jordan', 'last' => 'Clarkson', 'pos' => 'SG', 'gp' => 72, 'pts' => 20.7, 'reb' => 4.2, 'ast' => 4.5, 'stl' => 0.7, 'blk' => 0.3, 'fg' => 0.439, 'fg3' => 0.367, 'ft' => 0.836, 'min' => 30.5],
            ['team' => 'UTA', 'first' => 'John', 'last' => 'Collins', 'pos' => 'PF', 'gp' => 51, 'pts' => 13.8, 'reb' => 6.9, 'ast' => 1.8, 'stl' => 0.6, 'blk' => 0.5, 'fg' => 0.514, 'fg3' => 0.345, 'ft' => 0.731, 'min' => 26.5],
            ['team' => 'UTA', 'first' => 'Collin', 'last' => 'Sexton', 'pos' => 'PG', 'gp' => 68, 'pts' => 16.5, 'reb' => 2.8, 'ast' => 3.5, 'stl' => 0.8, 'blk' => 0.2, 'fg' => 0.471, 'fg3' => 0.381, 'ft' => 0.851, 'min' => 27.5],
            ['team' => 'UTA', 'first' => 'Keyonte', 'last' => 'George', 'pos' => 'PG', 'gp' => 65, 'pts' => 13.5, 'reb' => 3.2, 'ast' => 4.5, 'stl' => 0.8, 'blk' => 0.2, 'fg' => 0.421, 'fg3' => 0.351, 'ft' => 0.791, 'min' => 26.5],
            ['team' => 'UTA', 'first' => 'Walker', 'last' => 'Kessler', 'pos' => 'C', 'gp' => 72, 'pts' => 9.5, 'reb' => 9.2, 'ast' => 1.8, 'stl' => 0.5, 'blk' => 2.8, 'fg' => 0.691, 'fg3' => 0.000, 'ft' => 0.541, 'min' => 25.5],
            ['team' => 'UTA', 'first' => 'Talen', 'last' => 'Horton-Tucker', 'pos' => 'SF', 'gp' => 55, 'pts' => 10.5, 'reb' => 3.8, 'ast' => 3.2, 'stl' => 0.8, 'blk' => 0.3, 'fg' => 0.441, 'fg3' => 0.341, 'ft' => 0.761, 'min' => 22.5],

            // WASHINGTON WIZARDS
            ['team' => 'WAS', 'first' => 'Kyle', 'last' => 'Kuzma', 'pos' => 'PF', 'gp' => 55, 'pts' => 22.2, 'reb' => 6.7, 'ast' => 3.7, 'stl' => 0.9, 'blk' => 0.5, 'fg' => 0.441, 'fg3' => 0.329, 'ft' => 0.752, 'min' => 34.5],
            ['team' => 'WAS', 'first' => 'Tyus', 'last' => 'Jones', 'pos' => 'PG', 'gp' => 55, 'pts' => 14.9, 'reb' => 2.9, 'ast' => 6.8, 'stl' => 1.4, 'blk' => 0.3, 'fg' => 0.497, 'fg3' => 0.400, 'ft' => 0.839, 'min' => 29.5],
            ['team' => 'WAS', 'first' => 'Deni', 'last' => 'Avdija', 'pos' => 'SF', 'gp' => 73, 'pts' => 13.9, 'reb' => 5.9, 'ast' => 3.3, 'stl' => 1.2, 'blk' => 0.5, 'fg' => 0.484, 'fg3' => 0.356, 'ft' => 0.762, 'min' => 30.5],
            ['team' => 'WAS', 'first' => 'Jordan', 'last' => 'Poole', 'pos' => 'SG', 'gp' => 68, 'pts' => 17.5, 'reb' => 2.8, 'ast' => 4.5, 'stl' => 0.8, 'blk' => 0.2, 'fg' => 0.421, 'fg3' => 0.341, 'ft' => 0.821, 'min' => 29.5],
            ['team' => 'WAS', 'first' => 'Daniel', 'last' => 'Gafford', 'pos' => 'C', 'gp' => 35, 'pts' => 11.2, 'reb' => 6.8, 'ast' => 1.2, 'stl' => 0.8, 'blk' => 2.2, 'fg' => 0.711, 'fg3' => 0.000, 'ft' => 0.621, 'min' => 22.5],
            ['team' => 'WAS', 'first' => 'Corey', 'last' => 'Kispert', 'pos' => 'SF', 'gp' => 65, 'pts' => 12.5, 'reb' => 3.5, 'ast' => 1.8, 'stl' => 0.7, 'blk' => 0.3, 'fg' => 0.471, 'fg3' => 0.411, 'ft' => 0.841, 'min' => 26.5],
            ['team' => 'WAS', 'first' => 'Bilal', 'last' => 'Coulibaly', 'pos' => 'SF', 'gp' => 60, 'pts' => 9.5, 'reb' => 4.2, 'ast' => 2.1, 'stl' => 1.1, 'blk' => 0.6, 'fg' => 0.451, 'fg3' => 0.321, 'ft' => 0.711, 'min' => 23.5],
        ];

        $season = 2024;
        $count  = 0;

        foreach ($stats as $s) {
            $team = Team::where('abbreviation', $s['team'])->first();
            if (!$team) continue;

            $player = Player::updateOrCreate(
                ['first_name' => $s['first'], 'last_name' => $s['last']],
                [
                    'api_id'   => Player::max('api_id') + 1,
                    'team_id'  => $team->id,
                    'position' => $s['pos'],
                ]
            );

            PlayerStat::updateOrCreate(
                ['player_id' => $player->id, 'season' => $season],
                [
                    'games_played' => $s['gp'],
                    'pts'          => $s['pts'],
                    'reb'          => $s['reb'],
                    'ast'          => $s['ast'],
                    'stl'          => $s['stl'],
                    'blk'          => $s['blk'],
                    'fg_pct'       => $s['fg'],
                    'fg3_pct'      => $s['fg3'],
                    'ft_pct'       => $s['ft'],
                    'min'          => $s['min'],
                    'turnover'     => 0,
                ]
            );

            $count++;
        }

        $this->command->info("✅ {$count} estadísticas de jugadores insertadas.");
    }
}