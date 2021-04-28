/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Stage.entities;

/**
 *
 * @author imote
 */
public class OffreStage {
    private int id;
    private String nom_entreprise;
    private String description;
    private String stage_id;

    public OffreStage() {
    }

    public OffreStage(int id, String nom_entreprise, String description, String stage_id) {
        this.id = id;
        this.nom_entreprise = nom_entreprise;
        this.description = description;
        this.stage_id = stage_id;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom_entreprise() {
        return nom_entreprise;
    }

    public void setNom_entreprise(String nom_entreprise) {
        this.nom_entreprise = nom_entreprise;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getStage_id() {
        return stage_id;
    }

    public void setStage_id(String stage_id) {
        this.stage_id = stage_id;
    }

    @Override
    public String toString() {
        return stage_id + " proposé par " + nom_entreprise;
    }
   
    
}
