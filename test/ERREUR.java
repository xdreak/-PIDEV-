/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Stages.CandidatureStage.Gui;

import java.net.URL;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ResourceBundle;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.MouseEvent;
import Stage.entities.CandidatureStage;
import Base.MysqlConnect;
import Stage.entities.OffreStage;
import Stages.Services.OffreStageServices;
import javafx.scene.control.ComboBox;

/**
 * FXML Controller class
 *
 * @author imote
 */
public class ERREUR implements Initializable {

    @FXML
    private Label label;
    @FXML
    private TextField tfnom;
    @FXML
    private TextField tfprenom;
    @FXML
    private TextField tfcommentaire;
    @FXML
    private TextField tfemail;
    @FXML
    private TextField tfage;
    @FXML
    private TableView<CandidatureStage> tvcandidature;
    @FXML
    private TableColumn<CandidatureStage, String> colNom;
    @FXML
    private TableColumn<CandidatureStage, String> colPrenom;
    @FXML
    private TableColumn<CandidatureStage, String> colCommentaire;
    @FXML
    private TableColumn<CandidatureStage, String> colEmail;
    @FXML
    private TableColumn<CandidatureStage, Integer> colAge;
    @FXML
    private TableColumn<CandidatureStage, Integer> colidstage;
    @FXML
    private TableColumn<CandidatureStage, Integer> colId;
    @FXML
    private Button btnaddcandidaturestage;
    @FXML
    private Button btnaupdatecandidaturestage;
    @FXML
    private Button btndeletecandidaturestage;
    @FXML
    private TextField tfid;
    @FXML
    private ComboBox<?> cbstage;

    @FXML
    private void handleMouseAction(MouseEvent event) {
    }

    @FXML
    private void ajouterOffre(ActionEvent event) {
    }

    @FXML
    private void modifierOffre(ActionEvent event) {
    }

    @FXML
    private void supprimerOffre(ActionEvent event) {
    }
    

    /**
     * Initializes the controller class.
     */
       

   /* @FXML
    private void handleButtonAction(ActionEvent event) {
        if (event.getSource() == btnaddcandidaturestage){
            insertRecord();
        }else if(event.getSource()== btnaupdatecandidaturestage){
            updateRecord();
        }else if(event.getSource()== btndeletecandidaturestage){
            deleteButton();
        }*/
    
    
   /* public void showCandidatureStages(){
        OffreStageServices aS = new OffreStageServices();
        ObservableList<OffreStage> liste = aS.showOffre();
                colId.setCellValueFactory(new PropertyValueFactory<CandidatureStage, Integer>("id"));
                colidstage.setCellValueFactory(new PropertyValueFactory<CandidatureStage, Integer>("id_stage_id"));
                        colNom.setCellValueFactory(new PropertyValueFactory<CandidatureStage, String>("nom"));
                                colPrenom.setCellValueFactory(new PropertyValueFactory<CandidatureStage, String>("prenom"));
                                        colEmail.setCellValueFactory(new PropertyValueFactory<CandidatureStage, String>("email"));
                                                colAge.setCellValueFactory(new PropertyValueFactory<CandidatureStage, Integer>("age"));
                                                colCommentaire.setCellValueFactory(new PropertyValueFactory<CandidatureStage, String>("commentaire"));
                                                
                                                
        
    tvcandidature.setItems(liste);
    
    }*/
    /*
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        showCandidatureStages();
        // TODO
    }    
    public void executeQuery(String query){
        Connection conn = MysqlConnect.getInstance().getCnx();
        Statement st;
        try{
            st = conn.createStatement();
            st.executeUpdate(query);
        }catch(Exception ex){
            ex.printStackTrace();
        }
    }
    public void insertRecord(){
        String query = "INSERT into Candidature_Stage VALUES("+tfid.getText()+","+tfidstage.getText()+",'"+tfnom.getText()+"','"+tfprenom.getText()+"','"+tfemail.getText()+"',"+tfage.getText()+",'"+tfcommentaire.getText()+"')";
        executeQuery(query);
        showCandidatureStages();
    }
    public void updateRecord(){
        String query = "UPDATE Candidature_Stage SET nom = '"+tfnom.getText()+"',prenom='"+tfprenom.getText()+"',commentaire='"+tfcommentaire.getText()+"',email='"+tfemail.getText()+"',age="+tfage.getText()+",id_stage_id="+tfidstage.getText()+ " WHERE id = " +tfid.getText()+"";
        executeQuery(query);
        showCandidatureStages();
    }
    private void deleteButton(){
        String query = "DELETE FROM Candidature_Stage WHERE id=" +tfid.getText()+ "";
        executeQuery(query);
        showCandidatureStages();
    }
    @FXML
    private void handleMouseAction(MouseEvent event){
        CandidatureStage candidaturestage = tvcandidature.getSelectionModel().getSelectedItem();
        tfid.setText(""+candidaturestage.getId());
        tfprenom.setText(candidaturestage.getPrenom());
        tfnom.setText(candidaturestage.getNom());
        tfcommentaire.setText(candidaturestage.getCommentaire());
        tfemail.setText(candidaturestage.getEmail());
        tfage.setText(""+candidaturestage.getAge());
        tfidstage.setText(""+candidaturestage.getId_stage_id());
    }
    
}*/



