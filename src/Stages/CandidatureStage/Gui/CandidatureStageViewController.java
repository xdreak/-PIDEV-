/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Stages.CandidatureStage.Gui;

import Base.MysqlConnect;
import Stage.entities.CandidatureStage;
import Stage.entities.OffreStage;
import Stages.Services.CandidatureStageServices;
import Stages.Services.OffreStageServices;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.ResultSet;
import java.util.ArrayList;
import java.util.ResourceBundle;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.chart.PieChart;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.MouseEvent;


/**
 * FXML Controller class
 *
 * @author imote
 */
public class CandidatureStageViewController implements Initializable {

    @FXML
    private Label label;
    @FXML
    private TextField tfid;
    @FXML
    private ComboBox<OffreStage> cbstage;
    @FXML
    private TextField tfnom;
    @FXML
    private TextField tfprenom;
    @FXML
    private TextField tfage;
    @FXML
    private TextField tfemail;
    @FXML
    private TextField tfcommentaire;
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
    private PieChart piechart;
    
    ObservableList< PieChart.Data> piechartdata;
    ArrayList< String> p = new ArrayList< String>();     
    ArrayList< Integer> c = new ArrayList< Integer>();
    

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        showCandidatureStages();
        afficherCombo();
        loadData();
        piechart.setData(piechartdata);
        
    }    
    private void afficherCombo(){
        OffreStageServices AC= new OffreStageServices();
        ObservableList<OffreStage> liste = AC.showOffre();
        cbstage.setItems(liste);
    }
    public void showCandidatureStages(){
        CandidatureStageServices aS = new CandidatureStageServices();
        ObservableList<CandidatureStage> liste = aS.showCandidatures();
                colId.setCellValueFactory(new PropertyValueFactory<CandidatureStage, Integer>("id"));
                colidstage.setCellValueFactory(new PropertyValueFactory<CandidatureStage, Integer>("id_stage_id"));
                        colNom.setCellValueFactory(new PropertyValueFactory<CandidatureStage, String>("nom"));
                                colPrenom.setCellValueFactory(new PropertyValueFactory<CandidatureStage, String>("prenom"));
                                        colEmail.setCellValueFactory(new PropertyValueFactory<CandidatureStage, String>("email"));
                                                colAge.setCellValueFactory(new PropertyValueFactory<CandidatureStage, Integer>("age"));
                                                colCommentaire.setCellValueFactory(new PropertyValueFactory<CandidatureStage, String>("commentaire"));
                                                
                                                
        
    tvcandidature.setItems(liste);
    
    }
    
    @FXML
    private void ajouterCandidatureStages(ActionEvent event) throws IOException {
        
        
        int id = Integer.parseInt(tfid.getText());
        int stage = cbstage.getValue().getId();
        String nom = tfnom.getText();
                String prenom = tfprenom.getText();
        String email = tfemail.getText();
        int age = Integer.parseInt(tfage.getText());

        
        String commentaire = tfcommentaire.getText();
       
        CandidatureStage A = new CandidatureStage(id, stage, nom, prenom, email, age, commentaire);
        CandidatureStageServices aS = new CandidatureStageServices();
        if (aS.addCandidatureStage(A)){
        Alert alert = new Alert(AlertType.INFORMATION);
        alert.setTitle("Succées");
        alert.setHeaderText(null);
        alert.setContentText("L'ajout d'une nouvelle candidature a été effectué avec succées");
        alert.showAndWait();
        showCandidatureStages();
        afficherCombo();
        CandidatureStageServices Cs = new CandidatureStageServices();
        String path = Cs.QR(tfnom.getText(), tfprenom.getText());
        
        Cs.MailingCS(tfemail.getText(),tfprenom.getText(),tfnom.getText(),path);
        }else{
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Erreur");
        alert.setHeaderText(null);
        alert.setContentText("L'ajout d'une nouvelle candidature n'a pas été effectué!");
        alert.showAndWait();   
        showCandidatureStages();
        afficherCombo();

        }
    }

    

    @FXML
    private void modifierCandidatureStages(ActionEvent event) {
        CandidatureStage A= tvcandidature.getSelectionModel().getSelectedItem();
       
        int stage = cbstage.getValue().getId();
        String nom = tfnom.getText();
                String prenom = tfprenom.getText();
        String email = tfemail.getText();
        int age = Integer.parseInt(tfage.getText());

        
        String commentaire = tfcommentaire.getText();
        
        
        A.setId_stage_id(stage);
        A.setNom(nom);
        A.setPrenom(prenom);
        A.setEmail(email);
        A.setAge(age);
        A.setCommentaire(commentaire);
        CandidatureStageServices aS = new CandidatureStageServices();
        if (aS.updateCandidatureStage(A)){
        Alert alert = new Alert(AlertType.INFORMATION);
        alert.setTitle("Succées");
        alert.setHeaderText(null);
        alert.setContentText("La modification de candidature a été effectué avec succées");
        alert.showAndWait();
        showCandidatureStages();
                afficherCombo();

        }else{
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Erreur");
        alert.setHeaderText(null);
        alert.setContentText("La modification de candidature n'a pas été effectué!");
        alert.showAndWait();   
        showCandidatureStages();
                afficherCombo();

        }


    }

    @FXML
    private void supprimerCandidatureStages(ActionEvent event) {
        CandidatureStage A= tvcandidature.getSelectionModel().getSelectedItem();
        CandidatureStageServices aS = new CandidatureStageServices();
        if (aS.deleteCandidatureStage(A)){
        Alert alert = new Alert(AlertType.INFORMATION);
        alert.setTitle("Succées");
        alert.setHeaderText(null);
        alert.setContentText("La suppression de candidature a été effectué avec succées");
        alert.showAndWait();
        showCandidatureStages();
        }else{
        Alert alert = new Alert(AlertType.ERROR);
        alert.setTitle("Erreur");
        alert.setHeaderText(null);
        alert.setContentText("La supression de candidature n'a pas été effectué!");
        alert.showAndWait();   
        showCandidatureStages();
        }
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
       
    }
    public void loadData() {

        String query = "select COUNT(*) as count ,nom_entreprise from offre_stage GROUP BY nom_entreprise "; //ORDER BY P asc

        piechartdata = FXCollections.observableArrayList();

        Connection con = MysqlConnect.getInstance().getConnection();

        try {

            ResultSet rs = con.createStatement().executeQuery(query);
            while (rs.next()) {

                piechartdata.add(new PieChart.Data(rs.getString("nom_entreprise"), rs.getInt("count")));
                p.add(rs.getString("nom_entreprise"));
                c.add(rs.getInt("count"));
            }
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

        
    
    
}
