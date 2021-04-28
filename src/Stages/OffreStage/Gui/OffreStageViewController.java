/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Stages.OffreStage.Gui;

import Stage.entities.CandidatureStage;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.input.MouseEvent;
import Stage.entities.OffreStage;
import Stages.Services.OffreStageServices;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.scene.chart.PieChart;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.KeyEvent;
import java.io.*;
import com.sun.speech.freetts.*;
import javafx.geometry.Pos;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.util.Duration;
import org.controlsfx.control.Notifications;

/**
 * FXML Controller class
 *
 * @author imote
 */
public class OffreStageViewController implements Initializable {

    @FXML
    private Label label;
    @FXML
    private TextField tfid;
    @FXML
    private TextField tfnomenteprise;
    @FXML
    private TextField tfdescription;
    @FXML
    private TextField tfstageid;
    @FXML
    private TableView<OffreStage> tvoffrestage;
    @FXML
    private TableColumn<OffreStage, String> colNomentreprise;
    @FXML
    private TableColumn<OffreStage, String> colDescription;
    @FXML
    private TableColumn<OffreStage, String> colStageid;
    @FXML
    private TableColumn<OffreStage, Integer> colId;
    @FXML
    private Button btnaddcandidaturestage;
    @FXML
    private Button btnaupdatecandidaturestage;
    @FXML
    private Button btndeletecandidaturestage;
    @FXML
    private Button TriDESC;
    @FXML
    private Button TriASC;
    @FXML
    private TextField search;
    private static final String VOICENAME="kevin16";

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        afficherOffre();
    }   
    
    
    
    
    
    public void afficherOffre(){
         OffreStageServices aS = new OffreStageServices();
        ObservableList<OffreStage> liste = aS.showOffre();
                colId.setCellValueFactory(new PropertyValueFactory<OffreStage, Integer>("id"));
                colNomentreprise.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("nom_entreprise"));
                        colDescription.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("description"));
                                colStageid.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("stage_id"));
                                      
                                                
                                                
        
    tvoffrestage.setItems(liste);
    }
    @FXML
    

    
    private void ajouterOffre(ActionEvent event) {
        
        int id = Integer.parseInt(tfid.getText());
        String nom = tfnomenteprise.getText();
        String desc = tfdescription.getText();
        String stageid = tfstageid.getText();
        OffreStage A = new OffreStage(id, nom, desc, stageid);
        OffreStageServices aS = new OffreStageServices();
        if (aS.addOffreStage(A)){
        Alert alert = new Alert(AlertType.INFORMATION);
        alert.setTitle("Succées");
        alert.setHeaderText(null);
        alert.setContentText("L'ajout d'une nouvelle offre a été effectué avec succées");
        alert.showAndWait();
        afficherOffre();
        Voice voice;
        VoiceManager vm=VoiceManager.getInstance();
        voice = vm.getVoice(VOICENAME);
        
        voice.allocate();
        
        try{
            voice.speak("A new internship has been added with the attributes:");
            voice.speak(tfid.getText());
            voice.speak(tfnomenteprise.getText());
            voice.speak(tfdescription.getText());
            voice.speak(tfstageid.getText());
        }catch(Exception e){
            
        }
        //Image img=new Image("/icon1.png",true);
        Notifications notificationBuilder = Notifications.create()
                .title("Offre ajoutée")
                .text("Votre Offre de stage a été ajoutée avec succès")
                .graphic(null)
                .hideAfter(Duration.seconds(5))
                .position(Pos.BOTTOM_RIGHT );
        notificationBuilder.darkStyle();
                notificationBuilder.show();
                
        
        }else{
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Erreur");
        alert.setHeaderText(null);
        alert.setContentText("L'ajout d'une nouvelle offre n'a pas été effectué!");
        alert.showAndWait();   
        afficherOffre();
        
        
        }
    }

    @FXML
    private void modifierOffre(ActionEvent event) {
        OffreStage A= tvoffrestage.getSelectionModel().getSelectedItem();
                

        A.setDescription(tfdescription.getText());
        A.setStage_id(tfstageid.getText());
        A.setNom_entreprise(tfnomenteprise.getText());
        OffreStageServices aS = new OffreStageServices();
        if (aS.updateOffreStage(A)){
        Alert alert = new Alert(AlertType.INFORMATION);
        alert.setTitle("Succées");
        alert.setHeaderText(null);
        alert.setContentText("La modification d'offre a été effectué avec succées");
        alert.showAndWait();
        afficherOffre();
        }else{
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Erreur");
        alert.setHeaderText(null);
        alert.setContentText("La modification d'offre n'a pas été effectué!");
        alert.showAndWait();   
        afficherOffre();
        }

    }

    @FXML
    private void supprimerOffre(ActionEvent event) {
        OffreStage A= tvoffrestage.getSelectionModel().getSelectedItem();
        OffreStageServices aS = new OffreStageServices();
        if (aS.deleteOffreStage(A)){
        Alert alert = new Alert(AlertType.INFORMATION);
        alert.setTitle("Succées");
        alert.setHeaderText(null);
        alert.setContentText("La suppression d'offre a été effectué avec succées");
        alert.showAndWait();
        afficherOffre();
        }else{
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Erreur");
        alert.setHeaderText(null);
        alert.setContentText("La supression d'offre n'a pas été effectué!");
        alert.showAndWait();   
        afficherOffre();
        }
    }
    @FXML
    private void handleMouseAction(MouseEvent event){
        OffreStage offrestage = tvoffrestage.getSelectionModel().getSelectedItem();
        tfid.setText(""+offrestage.getId());
        tfnomenteprise.setText(offrestage.getNom_entreprise());
        tfdescription.setText(offrestage.getDescription());
        tfstageid.setText(offrestage.getStage_id());
        
    }
    @FXML
   private void TriDESC(ActionEvent event){
       OffreStageServices aS = new OffreStageServices();
        ObservableList<OffreStage> liste = aS.showOffreDESC();
         colId.setCellValueFactory(new PropertyValueFactory<OffreStage, Integer>("id"));
                colNomentreprise.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("nom_entreprise"));
                        colDescription.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("description"));
                                colStageid.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("stage_id"));
        tvoffrestage.setItems(liste);
    
   }
    @FXML
   private void TriASC(ActionEvent event){
       OffreStageServices aS = new OffreStageServices();
        ObservableList<OffreStage> liste = aS.showOffreASC();
         colId.setCellValueFactory(new PropertyValueFactory<OffreStage, Integer>("id"));
                colNomentreprise.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("nom_entreprise"));
                        colDescription.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("description"));
                                colStageid.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("stage_id"));
        tvoffrestage.setItems(liste);
    
   }

    @FXML
    private void recherche(KeyEvent event) {
        OffreStageServices aS = new OffreStageServices();
        String x = search.getText();
        ObservableList<OffreStage> liste = aS.showOffreRecherche(x);
         colId.setCellValueFactory(new PropertyValueFactory<OffreStage, Integer>("id"));
                colNomentreprise.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("nom_entreprise"));
                        colDescription.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("description"));
                                colStageid.setCellValueFactory(new PropertyValueFactory<OffreStage, String>("stage_id"));
        tvoffrestage.setItems(liste);
        
    }

    
    

    
   
    
    
}
