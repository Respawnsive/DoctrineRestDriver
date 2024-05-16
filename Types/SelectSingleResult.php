<?php
/**
 * This file is part of DoctrineRestDriver.
 *
 * DoctrineRestDriver is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DoctrineRestDriver is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DoctrineRestDriver.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Circle\DoctrineRestDriver\Types;

/**
 * Maps the response content of a GET query to a valid
 * Doctrine result for SELECT ... WHERE id = <id>
 *
 * @author    Tobias Hauck <tobias@circle.ai>
 * @copyright 2015 TeeAge-Beatz UG
 */
class SelectSingleResult {

    /**
     * Returns a valid Doctrine result for SELECT ... WHERE id = <id>
     *
     * @param  array  $tokens
     * @param  array  $content
     * @return string
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public static function create(array $tokens, $content,$joinTable = null) {


        // Suceptible d'etre lancé plusieur fois par selectAllResult , pour chaque table associé (en leftjoin)

        HashMap::assert($tokens, 'tokens');
        $tableAlias = Table::alias($tokens);

        // DUCH
        $attributeValueMap = array_map(function($token) use ($content, $tableAlias,$tokens,$joinTable) {
            $key   = empty($token['alias']['name']) ? $token['base_expr'] : $token['alias']['name'];

            if (str_starts_with($token['base_expr'] , 'c1_.')) // c1_.id
            {
                $tableName = null ;

                foreach ($tokens['FROM'] as $table)
                {
                    if ($table['alias']['name'] == 'c1_')
                    {
                        $tableName= $table['table'];
                    }

                    if ($tableName) {
                        $value = $content[$tableName][0][str_replace('c1_'  . '.', '', $token['base_expr'])] ; // pas bon
                        return [$key => $value] ;
                    }


                }

                // TODO c1_ << alias de "categories" , il faut retrouvé la correspondance , et ensuite $content['categories']['id'] << gerer multilevel !
//                dump($tableAlias);
            }
//            dump(str_replace($tableAlias . '.', '', $token['base_expr']),$token['base_expr'],$key);

            $value = $content[str_replace($tableAlias . '.', '', $token['base_expr'])];
            return [$key => $value];
        }, $tokens['SELECT']);

        return [
            array_reduce($attributeValueMap, 'array_merge', [])
        ];
    }
}
