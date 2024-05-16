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
 * Doctrine result for SELECT ... without WHERE id = <id>
 *
 * @author    Tobias Hauck <tobias@circle.ai>
 * @copyright 2015 TeeAge-Beatz UG
 */
class SelectAllResult {

    /**
     * Returns a valid Doctrine result for SELECT ... without WHERE id = <id>
     *
     * @param  array  $tokens
     * @param  array  $content
     * @return string
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public static function create(array $tokens, array $content) {
        // DUCH
        $content = self::orderBy($tokens, $content);

        $joinTable = [];
        foreach ($tokens['FROM'] as $table)
            $joinTable[$table['table']] = true;
        $joinTable = array_keys($joinTable);

//        $content = array_map(function($entry) use ($tokens) {
//            // Pour chaque catégorie/associations on dois doubler la ligne. // TODO Si 3 association 3 fois plus de ligne!
//            $row = SelectSingleResult::create($tokens, $entry); // DUCH
//            // Check JOIN
//            return array_pop($row);
//        }, $content);
//
//        dd($content);

        $contentCopy = $content ;
        $content = [] ;
        foreach ($contentCopy as $entry)
        {

            if (count($joinTable) > 0) {
                foreach ($joinTable as $table) {
                    $row = SelectSingleResult::create($tokens, $entry, $joinTable)[0];
                    $content[] = $row ;
                }
            }
            else
            {
                $row = SelectSingleResult::create($tokens, $entry, $joinTable)[0];
                $content[] = $row ;
            }


        }




        // Pour chacune des association il faut crée les ligne du left join
        $content[] = $content[0] ; // TEST
        $content[0]['name_4'] = "CATEG" ; // TEST
        $content[0]['id_3'] = 1 ; // TEST

//        dd($content);

        return $content ;
    }

    /**
     * Orders the content with the given order by criteria
     *
     * @param  array $tokens
     * @param  array $content
     * @return array
     */
    public static function orderBy(array $tokens, array $content) {
        if (empty($tokens['ORDER'])) return $content;

        $sortingRules = array_map(function($token) use ($content) {
            return [
                end($token['no_quotes']['parts']),
                $token['direction']
            ];
        }, $tokens['ORDER']);

        $reducedSortingRules = array_reduce($sortingRules, 'array_merge', []);
        $sortArgs            = array_map(function($value) use ($content) {
            if ($value === 'ASC')  return SORT_ASC;
            if ($value === 'DESC') return SORT_DESC;

            $contents = [];
            foreach ($content as $c) array_push($contents, $c[$value]);
            return $contents;
        }, $reducedSortingRules);

        $sortArgs[] = &$content;
        call_user_func_array('array_multisort', $sortArgs);

        return end($sortArgs);
    }
}
