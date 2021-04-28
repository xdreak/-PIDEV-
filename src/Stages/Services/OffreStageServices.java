/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Stages.Services;

import Base.MysqlConnect;
import Stage.entities.OffreStage;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

/**
 *
 * @author imote
 */
public class OffreStageServices {
    public ObservableList<OffreStage> showOffre(){
        Connection cnx =null;
        Statement st = null;
        ResultSet rs = null;
        ObservableList<OffreStage> liste = FXCollections.observableArrayList();
        String requette = "SELECT * FROM offre_stage";
        
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            rs = st.executeQuery(requette);
            OffreStage OffreStages;
            while (rs.next()){
               OffreStages = new OffreStage(rs.getInt("id"), rs.getString("nom_entreprise"), rs.getString("description"), rs.getString("stage_id"));
               liste.add(OffreStages);
            }
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
        }finally {
    if (rs != null) {
        try {
            rs.close();
        } catch (SQLException e) { /* Ignored */}
    }
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }
        return liste;
        
}
    public boolean addOffreStage(OffreStage a){
        Connection cnx =null;
        Statement st = null;
        String requette = "INSERT INTO Offre_Stage (nom_entreprise,description,stage_id,id) VALUES ('"+a.getNom_entreprise()+"','"+a.getDescription()+"','"+a.getStage_id()+"',"+a.getId()+")";
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            st.executeUpdate(requette);
            return true;
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
            return false;
        }finally {
    
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }
        
    }
public boolean updateOffreStage(OffreStage a){
        Connection cnx =null;
        Statement st = null;
        String requette = "UPDATE offre_stage set nom_entreprise='"+a.getNom_entreprise()+"',description='"+a.getDescription()+"',stage_id='"+a.getStage_id()+"' WHERE id="+a.getId()+"";
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            st.executeUpdate(requette);
            return true;
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
            return false;
        }finally {
    
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }}
        
        public boolean deleteOffreStage(OffreStage a){
        Connection cnx =null;
        Statement st = null;
        String requette = "DELETE FROM Offre_Stage WHERE id="+a.getId()+"";
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            st.executeUpdate(requette);
            return true;
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
            return false;
        }finally {
    
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }
        
    }
        public ObservableList<OffreStage> showOffreDESC(){
        Connection cnx =null;
        Statement st = null;
        ResultSet rs = null;
        ObservableList<OffreStage> liste = FXCollections.observableArrayList();
        String requette = "SELECT * FROM offre_stage ORDER BY stage_id DESC";
        
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            rs = st.executeQuery(requette);
            OffreStage OffreStages;
            while (rs.next()){
               OffreStages = new OffreStage(rs.getInt("id"), rs.getString("nom_entreprise"), rs.getString("description"), rs.getString("stage_id"));
               liste.add(OffreStages);
            }
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
        }finally {
    if (rs != null) {
        try {
            rs.close();
        } catch (SQLException e) { /* Ignored */}
    }
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }
        return liste;
        }
        public ObservableList<OffreStage> showOffreASC(){
        Connection cnx =null;
        Statement st = null;
        ResultSet rs = null;
        ObservableList<OffreStage> liste = FXCollections.observableArrayList();
        String requette = "SELECT * FROM offre_stage ORDER BY stage_id ASC";
        
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            rs = st.executeQuery(requette);
            OffreStage OffreStages;
            while (rs.next()){
               OffreStages = new OffreStage(rs.getInt("id"), rs.getString("nom_entreprise"), rs.getString("description"), rs.getString("stage_id"));
               liste.add(OffreStages);
            }
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
        }finally {
    if (rs != null) {
        try {
            rs.close();
        } catch (SQLException e) { /* Ignored */}
    }
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }
        return liste;
        }
        public ObservableList<OffreStage> showOffreRecherche(String x){
        Connection cnx =null;
        Statement st = null;
        ResultSet rs = null;
        ObservableList<OffreStage> liste = FXCollections.observableArrayList();
        
        String requette = "SELECT * FROM offre_stage  WHERE stage_id LIKE '%"+x+"%'";
        
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            rs = st.executeQuery(requette);
            OffreStage OffreStages;
            while (rs.next()){
               OffreStages = new OffreStage(rs.getInt("id"), rs.getString("nom_entreprise"), rs.getString("description"), rs.getString("stage_id"));
               liste.add(OffreStages);
            }
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
        }finally {
    if (rs != null) {
        try {
            rs.close();
        } catch (SQLException e) { /* Ignored */}
    }
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }
        return liste;
        
}
        
    
}
