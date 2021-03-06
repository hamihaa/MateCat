<?php
/**
 * Created by PhpStorm.
 * @author ostico domenico@translated.net / ostico@gmail.com
 * Date: 19/06/19
 * Time: 20.03
 *
 */

namespace Analysis;


use Database;
use Log;
use PDO;
use PDOException;

class AnalysisDao {


    /**
     *
     * REALLY HEAVY
     *
     * @param $pid
     *
     * @return array|int|mixed
     */
    public static function getProjectStatsVolumeAnalysis( $pid ) {

        $query = "
        SELECT
                st.id_job AS jid,
                j.password as jpassword,
                st.id_segment AS sid,
                s.id_file,
                f.filename,
                s.raw_word_count,
                st.suggestion_source,
                st.suggestion_match,
                st.eq_word_count,
                st.standard_word_count,
                st.match_type,
                p.status_analysis,
                p.fast_analysis_wc,
                p.tm_analysis_wc,
                p.standard_analysis_wc,
                st.tm_analysis_status AS st_status_analysis,
                st.locked as translated
			FROM
			  segment_translations AS st
			JOIN
			  segments AS s ON st.id_segment = s.id
			JOIN
			  jobs AS j ON j.id = st.id_job
			JOIN
			  projects AS p ON p.id = j.id_project
			JOIN
			  files f ON s.id_file = f.id
			WHERE
			  p.id = :pid
			AND p.status_analysis IN ('NEW' , 'FAST_OK', 'DONE')
			AND s.id BETWEEN j.job_first_segment AND j.job_last_segment
			AND ( st.eq_word_count != 0  OR s.raw_word_count != 0 )
			ORDER BY j.id, j.job_last_segment
			";

        $db = Database::obtain();
        try {
            $stmt = $db->getConnection()->prepare( $query );
            $stmt->setFetchMode( PDO::FETCH_ASSOC );
            $stmt->execute( [ 'pid' => $pid ] );
            $results = $stmt->fetchAll();
            $stmt->closeCursor();
        } catch ( PDOException $e ) {
            Log::doJsonLog( $e->getMessage() );
            return $e->getCode() * -1;
        }
        return $results;
    }

}